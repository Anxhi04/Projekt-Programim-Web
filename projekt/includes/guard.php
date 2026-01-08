<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirection
if (!isset($_SESSION["id"])) {
    header("Location:/Projekt-Programim-Web/projekt/public/login.html");
    exit;
}

$timeout = 15*60;

// Timeout session
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout) {
    session_unset();
    session_destroy();
    header("Location:/Projekt-Programim-Web/projekt/public/login.html");
    exit;
}

$_SESSION['LAST_ACTIVITY'] = time();

