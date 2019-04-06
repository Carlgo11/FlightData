<?php
require __DIR__ . '/php/session.php';

$flight_str = filter_input(INPUT_GET, 'flight', FILTER_SANITIZE_STRING);
if ($flight_str) {
    require_once __DIR__ . '/php/Flight/IATACodes.php';
    require_once __DIR__ . '/php/Flight/Flight.php';
    require_once __DIR__ . '/vendor/autoload.php';

    $request = new Flightdata\Flight\IATACodes();
    $request->setMethod('flights');
    $request->addParam('flight[icao_number]', $flight_str);
    $request->execute();
    $response = $request->getResponse();

    $loader = new \Twig_Loader_Filesystem(__DIR__ . '/templates');
    $twig = new \Twig_Environment($loader, ['cache' => __DIR__ . '/.compilation_cache']);
    $template = $twig->load('flight.html');

    // Catch any exceptions caused by malformed data.
    try {
        $flight = new Flight($response[0]);

        $vars = ['flight_ICAO' => $flight->getFlightICAO(),
            'flight_IATA' => $flight->getFlightIATA(),
            'aircraft_type' => $flight->getAirplane()->getVehicleICAO(),
            'aircraft_tail' => $flight->getAirplane()->getTailNumber(),
            'airline' => $flight->getAirline()->getName(),
            'airline_icao' => $flight->getAirline()->getICAO(),
            'departure_airport' => $flight->getOrigin(),
            'arrival_airport' => $flight->getDestination(),
            'flight_status' => $flight->getStatus()];

    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }

    $vars['username'] = $_SESSION['username'];
    $vars['gravatar'] = $_SESSION['gravatar'];


    echo $template->render($vars);
} else {
    // If not flight number is set, go back to homepage.
    Header("Location: ./");
}
