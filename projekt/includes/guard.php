<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();

}
//  MBROJTJA – RIDREJTIMI
if (!isset($_SESSION["id"])) {
    header("Location:/Projekt-Programim-Web-GIT/projekt/public/login.html");
    exit;
}

