<?php

use Flightdata\Flight\IATACodes;

require __DIR__ . '/php/session.php';

require_once __DIR__ . '/php/Flight/IATACodes.php';
require_once __DIR__ . '/php/Flight/Airport.php';
require_once __DIR__ . '/vendor/autoload.php';

$vars['username'] = $_SESSION['username'];
$vars['gravatar'] = $_SESSION['gravatar'];

$airportICAO = filter_input(INPUT_GET, 'airport');
if ($airportICAO != "") {
    $request = new IATACodes();
    $request->setMethod('mixed');
    $request->addParam('method[airports][icao_code]', $airportICAO);
    $request->addParam('page', '0');
    $request->addParam('limit', '10');
    $request->addParam('method[flights][departure][icao_code]', $airportICAO);

    $status = $request->execute();
    $response = $request->getResponse();
    unset($request);

// If more no or more than one airports are found, output error.
    if (count($response['airports']) == 1) {

        $arrival_request = new IATACodes();
        $arrival_request->setMethod('flights');
        $arrival_request->addParam('arrival[icao_code]', $airportICAO);
        $arrival_request->addParam('page', '0');
        $arrival_request->addParam('limit', '10');
        $arrival_request->execute();

        $vars['arrivals'] = $arrival_request->getResponse();
        unset($arrival_request);

        // Set template variables.
        $vars['airport'] = $response['airports']['response'][0];
        $vars['departures'] = array_slice($response['flights']['response'], 0, 10);
    } else {
        die("Airports != 1");
    }
}

$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new Twig_Environment($loader, ['cache' => __DIR__ . '/.compilation_cache']);

$template = $twig->load('airport.html');
echo $template->render($vars);