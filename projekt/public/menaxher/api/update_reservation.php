<?php
require_once __DIR__ . '/../functionemail.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db.php';
header('Content-Type: application/json');

// Marrim JSON input nga frontend-i
$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'] ?? null;

if (!$email) {
    http_response_code(400);
    echo json_encode([
        "error" => "Email është i detyrueshëm",
        "received" => $data
    ]);
    exit;
}

// Kontrollojmë nëse ekziston përdoruesi
$email = mysqli_real_escape_string($connection, $email);
$q = mysqli_query($connection, "SELECT id FROM users WHERE email = '$email'");
$user = mysqli_fetch_assoc($q);

if (!$user) {
    http_response_code(404);
    echo json_encode([
        "error" => "Nuk ekziston asnjë përdorues me këtë email"
    ]);
    exit;
}

// Gjenerojmë token
$token = bin2hex(random_bytes(32));
$token_hash = hash("sha256", $token);
$expires_at = date("Y-m-d H:i:s", time() + 3600); // 1 orë skadimi

$user_id = (int)$user['id'];

// Ruajmë token në DB
$insert = mysqli_query(
    $connection,
    "INSERT INTO password_resets (user_id, reset_token_hash, expires_at)
     VALUES ($user_id, '$token_hash', '$expires_at')"
);

if (!$insert) {
    http_response_code(500);
    echo json_encode([
        "error" => "Nuk u regjistrua token-i",
        "details" => mysqli_error($connection)
    ]);
    exit;
}

// Krijojmë linkun e resetit
$reset_link = "http://localhost/reset_password.php?token=$token";

// Dërgojmë email-in përmes PHPMailer
$emailSent = sendEmail([
    "user_email" => $email,
    "reset_link" => $reset_link
]);

echo json_encode([
    "success" => true,
    "message" => "Emaili për reset u dërgua me sukses",
    "email_sent" => $emailSent
]);
?>
