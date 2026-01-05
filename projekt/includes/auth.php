<?php
session_start();
require_once __DIR__ . "/../../db.php";

// nese nuk ka session por ka cookie remember_me
if (!isset($_SESSION["id"]) && !empty($_COOKIE["remember_me"])) {

    $token = $_COOKIE["remember_me"];
    $token_hash = hash("sha256", $token);

    // kerkojme token aktiv
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

        // marrim te dhenat e user-it
        $userRes = mysqli_query(
            $connection,
            "SELECT id, name, email, role
             FROM users
             WHERE id = $userId
             LIMIT 1"
        );

        if ($userRes && mysqli_num_rows($userRes) == 1) {

            $user = mysqli_fetch_assoc($userRes);

            // krijojme session-in
            $_SESSION["id"]    = $user["id"];
            $_SESSION["name"]  = $user["name"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["role"]  = $user["role"];

        } else {
            // user nuk ekziston me
            setcookie("remember_me", "", time() - 3600, "/");
        }

    } else {
        // token i pavlefshem / skaduar / revokuar
        setcookie("remember_me", "", time() - 3600, "/");
    }
}
