<?php
$hash = filter_input(INPUT_SERVER, 'REMOTE_ADDR') . filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');
session_start();
if (!isset($_SESSION['session']) || $_SESSION['session'] !== $hash) {
    header('Location: login.php');
    die("Not authenticated. Please login.");
}