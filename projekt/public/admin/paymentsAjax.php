<?php
require_once __DIR__ . "/../../../db.php";
session_start();

header("Content-Type: application/json");

// Vetëm admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode([
        "status" => 403,
        "message" => "Forbidden"
    ]);
    exit;
}

$action = $_POST['action'] ?? '';

function response($status, $message = null, $data = null) {
    echo json_encode([
        "status" => $status,
        "message" => $message,
        "data" => $data
    ]);
    exit;
}


switch ($action) {


    case 'fetch_payments':

        $result = $connection->query("
            SELECT
                reservation_id,
                provider,
                amount,
                status,
                created_at
            FROM payments
            ORDER BY created_at DESC
        ");

        $payments = [];
        while ($row = $result->fetch_assoc()) {
            $payments[] = $row;
        }

        response(200, null, $payments);
        break;

    default:
        response(400, "Invalid action");
}
