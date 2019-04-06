<?php

require __DIR__ . '/php/session.php';
require_once __DIR__ . '/vendor/autoload.php';

if (isset($_POST['query']) || isset($_GET['flight'])) {
    require_once __DIR__ . '/php/Flight/IATACodes.php';
    require_once __DIR__ . '/php/Flight/Vehicle.php';
    require_once __DIR__ . '/php/Flight/Airplane.php';

    $request = new Flightdata\Flight\IATACodes(7, 'flights');

    $method = filter_input(INPUT_POST, 'method', FILTER_SANITIZE_STRING);
    $query = filter_input(INPUT_POST, 'query', FILTER_SANITIZE_STRING);

    if ($method === "flight")
        $request->addParam('flight[icao_number]', $query);
    else if ($method === "tail")
        $request->addParam('aircraft[reg_number]', $query);
    else if ($method === "airline")
        $request->addParam('airline[icao_code]', $query);

    $request->execute();
    $responses = $request->getResponse();
    $vars['responses'] = $responses;
}

// Load template
$loader = new \Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new \Twig_Environment($loader, ['cache' => __DIR__ . '/.compilation_cache']);

$vars['username'] = $_SESSION['username'];
$vars['gravatar'] = $_SESSION['gravatar'];

$template = $twig->load('search.html');
echo $template->render($vars);