<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../db.php";

// Remember me handler
if (!isset($_SESSION["id"]) && !empty($_COOKIE["remember_token"])) {

    $token = $_COOKIE["remember_token"];
    $token_hash = hash("sha256", $token);

    $sql = "SELECT user_id
            FROM remember_tokens
            WHERE token_hash = '$token_hash'
              AND expires_at > NOW()
              AND revoked_at IS NULL
            LIMIT 1";

    $result = mysqli_query($connection, $sql);

    if ($result && mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);
        $userId = (int)$row["user_id"];

        $userRes = mysqli_query(
            $connection,
            "SELECT id, firstname, email, role
             FROM users
             WHERE id = $userId
             LIMIT 1"
        );

        if ($userRes && mysqli_num_rows($userRes) == 1) {
            $user = mysqli_fetch_assoc($userRes);

            // krijo session-in
            $_SESSION["id"] = $user["id"];
            $_SESSION["firstname"] = $user["firstname"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["role"] = $user["role"];

        } else {
            setcookie("remember_token", "", time() - 3600, "/");
        }
    } else {
        setcookie("remember_token", "", time() - 3600, "/");
    }
}

// Sesssion check
if (!isset($_SESSION["id"])) {
    header("Location: /Projekt-Programim-Web/projekt/public/login.php");
    exit;
}

// Sesssion timeout
$timeout = 15*60; // 15 minuta

if (isset($_SESSION["LAST_ACTIVITY"]) && (time() - $_SESSION["LAST_ACTIVITY"]) > $timeout) {

    // nese ka remember_me mos e shkaterro session
    if (empty($_COOKIE["remember_token"])) {
        session_unset();
        session_destroy();
        header("Location: /Projekt-Programim-Web/projekt/public/login.php");
        exit;
    }
}

$_SESSION["LAST_ACTIVITY"] = time();
