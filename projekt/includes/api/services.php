<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../../db.php'; // <- kjo është rruga e saktë sipas screenshot-it tënd

// 1) kontrollo lidhjen
if (!isset($connection) || !$connection) {
    http_response_code(500);
    echo json_encode([
        "error" => "No DB connection",
        "details" => "Check db.php (host/user/pass/port/db)"
    ]);
    exit;
}

mysqli_set_charset($connection, "utf8mb4");


$businessId = isset($_GET['business_id']) ? (int)$_GET['business_id'] : 1;

$sql = "
    SELECT
        id,
        category,
        name,
        description,
        duration_minutes,
        price
    FROM services
    WHERE business_id = $businessId
    ORDER BY id ASC
";

$result = mysqli_query($connection, $sql);


if ($result === false) {
    http_response_code(500);
    echo json_encode([
        "error" => "Query failed",
        "mysql_errno" => mysqli_errno($connection),
        "mysql_error" => mysqli_error($connection),
        "sql" => $sql
    ]);
    exit;
}


$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
