<?php

if (isset($_POST['username'])) {
    require_once __DIR__ . '/php/Database.php';
    $db = new Flightdata\Database();
    require __DIR__ . '/php/Authentication/User.php';
    $user = $db->getUser($_POST['username']);
    if ($user->verifyPassword($_POST['password'])) {
        session_start();
        $hash = filter_input(INPUT_SERVER, 'REMOTE_ADDR') . filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');

        $_SESSION['session'] = $hash;
        $_SESSION['gravatar'] = $user->getGravatarURI('?s=25d=mp&r=g');
        $_SESSION['username'] = $user->getUsername();

        header('Location: .');
    } else {
        $error = 'Wrong username or password';
    }
}

require_once __DIR__ . '/vendor/autoload.php';

$loader = new \Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new \Twig_Environment($loader, ['cache' => __DIR__ . '/.compilation_cache']);

$input = [];
if (isset($error)) $input['error'] = $error;

$template = $twig->load('login.html');
echo $template->render($input);
