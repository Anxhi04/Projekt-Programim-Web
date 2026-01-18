<?php
require_once __DIR__ . '/../functionemail.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db.php';
header('Content-Type: application/json');
//Ketu behet update i statusit te nje reservation dhe dergohet email
$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'] ?? null;
$status = $data['status'] ?? null;
$email = $data['email'] ?? null;

if(!$id || !$status || !$email){
    http_response_code(400);
    echo json_encode(["error"=>"Missing data", "received"=>$data]);
    exit;
}


$id = (int)$id;
$status = mysqli_real_escape_string($connection, $status);


$query = "UPDATE reservations SET status = '$status' WHERE id = $id";
$result = mysqli_query($connection, $query);

if(!$result){
    http_response_code(500);
    echo json_encode([
        "error" => "MySQL query failed",
        "details" => mysqli_error($connection)
    ]);
    exit;
}


$emailSent = sendEmail([
    "user_email" => $email,
    "code" => strtoupper($status),
    "id" => $id,
    "token" => uniqid()
]);


echo json_encode([
    "success" => true,
    "message" => "Emaili u dergua me sukses",
    "email_sent" => $emailSent
]);
