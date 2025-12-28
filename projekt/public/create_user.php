<?php
require_once dirname(__DIR__, 2) . '/db.php';

$password = '123456';
$hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, password_hash, role, is_active)
        VALUES ('Test User', 'test@gmail.com', '$hash', 'user', 1)";

if (mysqli_query($connection, $sql)) {
    echo "User created successfully";
} else {
    echo "Error: " . mysqli_error($connection);
}
