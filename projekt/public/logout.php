<?php
// File: `projekt/public/logout.php`
session_start();
require_once __DIR__ . "/../../db.php"; // logout.php është te public/

// normalize DB connection variable (handles different names used in db.php)
if (!isset($connection)) {
    if (isset($conn)) {
        $connection = $conn;
    } elseif (isset($mysqli) && $mysqli instanceof mysqli) {
        $connection = $mysqli;
    } elseif (defined('DB_HOST') && defined('DB_USER')) {
        $connection = @mysqli_connect(DB_HOST, DB_USER, defined('DB_PASS') ? DB_PASS : '', defined('DB_NAME') ? DB_NAME : '');
        if (!$connection) {
            $connection = null;
        }
    } else {
        $connection = null;
    }
}

// revoke token + clear cookie
if (!empty($_COOKIE['remember_me'])) {
    $token_hash = hash('sha256', $_COOKIE['remember_me']);

    if ($connection) {
        $stmt = mysqli_prepare($connection, "UPDATE remember_tokens SET revoked_at = NOW() WHERE token_hash = ? AND revoked_at IS NULL");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 's', $token_hash);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }

    // delete cookie with same params as when created
    setcookie('remember_me', '', [
        'expires' => time() - 3600,
        'path' => '/',
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

// destroy session
$_SESSION = [];
session_destroy();

// final redirect
header('Location: login.html');
exit;
