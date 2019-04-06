<?php
require __DIR__ . '/php/session.php';

require_once __DIR__ . '/php/Flight/IATACodes.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/php/Flight/Airline.php';

$icao_code = filter_input(INPUT_GET, 'icao', FILTER_SANITIZE_STRING);
$iata_code = filter_input(INPUT_GET, 'iata', FILTER_SANITIZE_STRING);

$vars['username'] = $_SESSION['username'];
$vars['gravatar'] = $_SESSION['gravatar'];

// Check if icao code or iata code are set.
if (isset($icao_code) || isset($iata_code)) {
    $request = new Flightdata\Flight\IATACodes();
    $request->setMethod('airlines');
    if (isset($icao_code))
        $request->addParam('icao_code', $icao_code);
    if (isset($iata_code))
        $request->addParam('iata_code', $iata_code);
    $request->addParam('page', '0');
    $request->addParam('limit', '1');
    $status = $request->execute();
    $airlines = $request->getResponse();

    $airline = new Flightdata\Flight\Airline($airlines[0]);

    $airline->setURL($airlines[0]['website']);
    $airline->setFacebook(explode("/", $airlines[0]['facebook'])[1]);
    $airline->setTwitter(explode("/", $airlines[0]['twitter'])[1]);
    $airline->setFleet($airlines[0]['fleet_size'], $airlines[0]['fleet_age']);
    $fleet = $airline->getFleet();

// Set template variables.
    $vars['airline'] = [
        'name' => $airline->getName(),
        'iata' => $airline->getIATA(),
        'icao' => $airline->getICAO(),
        'callsign' => $airline->getCallsign(),
        'twitter' => $airline->getTwitter(),
        'facebook' => $airline->getFacebook(),
        'url' => $airline->getURL(),
        'fleet' => $fleet,

    ];
}

$loader = new \Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new \Twig_Environment($loader, ['cache' => __DIR__ . '/.compilation_cache']);

$template = $twig->load('airline.html');
echo $template->render($vars);
