<?php
require_once __DIR__ . '/vendor/autoload.php';

// Check if form data has been submitted.
if (isset($_POST['username'])) {
    require_once __DIR__ . '/php/Authentication/User.php';
    require_once __DIR__ . '/php/Database.php';

    // Filter user input.
    $password = filter_input(INPUT_POST, 'password');
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $firstname = filter_input(INPUT_POST, 'firstname');
    $lastname = filter_input(INPUT_POST, 'lastname');
    $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR');

    // Create new User object.
    $user = new \Flightdata\Authentication\User();

    // Insert user input into User object.
    $user->setUsername(filter_input(INPUT_POST, 'username'));
    $user->setPasswordHash($passwordHash);
    $user->setFirstName($firstname);
    $user->setLastName($lastname);
    $user->setEmailAddress($email);
    $user->setIPAddress($ip);

    // Execute DB query
    $db = new \Flightdata\Database();
    if ($db->addUser($user))
        header("Location: index.php");
}

$loader = new \Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new \Twig_Environment($loader, ['cache' => __DIR__ . '/.compilation_cache']);

$template = $twig->load('register.html');
echo $template->render();
