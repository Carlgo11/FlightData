<?php

require __DIR__ . '/php/session.php';

require_once __DIR__ . '/php/Flight/IATACodes.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/php/Flight/Vehicle.php';
require_once __DIR__ . '/php/Flight/Airplane.php';
require_once __DIR__ . '/php/Flight/Airline.php';

use Flightdata\Flight\IATACodes;

$reg_number = filter_input(INPUT_GET, 'reg_number', FILTER_SANITIZE_STRING);
$vars['username'] = $_SESSION['username'];
$vars['gravatar'] = $_SESSION['gravatar'];

if ($reg_number != "") {
    $request = new IATACodes();
    $request->setMethod('airplanes');
    $request->setVersion(6);
    $request->addParam('reg_number', $reg_number);
    $request->addParam('page', '0');
    $request->addParam('limit', '1');
    $request->execute();

    $aircrafts = $request->getResponse();

    if (is_array($aircrafts) && count($aircrafts) === 1) {
        $airplane = new Flightdata\Flight\Airplane($aircrafts[0]);
        unset($request);

        $request = new Flightdata\Flight\IATACodes();
        $request->setMethod('airlines');
        $request->addParam('iata_code', $aircrafts[0]['airline_iata']);
        $request->addParam('page', '0');
        $request->addParam('limit', '1');
        $request->execute();

        $airlines = $request->getResponse();
        $airline = new Flightdata\Flight\Airline($airlines[0]);

        $first_flight = new DateTime($aircrafts[0]['first_flight']);
        $first_flight = $first_flight->format("Y-m-d");

        // Set template variables.
        $vars['aircraft'] = [
            'name' => $airplane->getName(),
            'tail_number' => $airplane->getTailNumber(),
            'owner' => $airplane->getOwner(),
            'model' => $aircrafts[0]['aircraft_type'],
            'age' => $aircrafts[0]['age'],
            'type' => $aircrafts[0]['engines_type'],
            'first_flight' => $first_flight,
        ];
        $vars['airline'] = [
            'name' => $airline->getName(),
            'icao' => $airline->getICAO()
        ];
        $vars['classes'] = $aircrafts[0]['classes'];
    }
    $vars['error'] = "Aircraft not found.";
}

$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new Twig_Environment($loader, ['cache' => __DIR__ . '/.compilation_cache']);

$template = $twig->load('aircraft.html');
echo $template->render($vars);
