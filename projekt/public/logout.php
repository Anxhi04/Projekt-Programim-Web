<?php
session_start();
require_once __DIR__ . "/../db.php"; // logout.php është te public/

// revoko token + fshi cookie
if (!empty($_COOKIE["remember_me"])) {
    $token_hash = hash("sha256", $_COOKIE["remember_me"]);

    mysqli_query(
        $connection,
        "UPDATE remember_tokens
         SET revoked_at = NOW()
         WHERE token_hash = '$token_hash'
           AND revoked_at IS NULL"
    );

    // fshi cookie (ME TË NJËJTAT parametra si kur u krijua)
    setcookie("remember_me", "", [
        "expires" => time() - 3600,
        "path" => "/",
        "secure" => false,
        "httponly" => true,
        "samesite" => "Lax",
    ]);
}
// shkatërro session
$_SESSION = [];
session_destroy();

// RIDREJTIM FINAL
header("Location: login.html"); // ose login.php
exit;
