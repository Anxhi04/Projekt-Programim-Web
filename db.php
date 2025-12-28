<?php
$config = require __DIR__ . '/projekt/config/config.php';

$connection = mysqli_connect(
    $config['db_host'],           // host
    $config['db_user'],           // username
    $config['db_pass'],           // password
    $config['db_name'],           // database
    (int)$config['db_port']       // port (INT!)
);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
else
    echo "Connected successfully";

mysqli_set_charset($connection, 'utf8mb4');
