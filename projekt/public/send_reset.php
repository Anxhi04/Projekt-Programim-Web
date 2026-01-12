<?php
require_once __DIR__ . '/set_reset.php';
require_once __DIR__ . '/../../db.php';


header('Content-Type: application/json');

// Marrim JSON input
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

// Sigurojmë email-in
$email = mysqli_real_escape_string($connection, $email);

// Gjejmë user-in
$query = "SELECT id, email FROM users WHERE email = '$email' LIMIT 1";
$result = mysqli_query($connection, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    http_response_code(404);
    echo json_encode([
        "error" => "Nuk u gjet përdorues me këtë email"
    ]);
    exit;
}

$user = mysqli_fetch_assoc($result);
$user_id = (int)$user['id'];

// Gjenerojmë token
$rawToken   = bin2hex(random_bytes(32));      // token që shkon në email
$tokenHash = hash('sha256', $rawToken);       // token që ruhet në DB
$expiresAt = date('Y-m-d H:i:s', time() + 3600);

// (Opsionale) Fshij reset-e të vjetra për user-in
mysqli_query($connection, "DELETE FROM password_resets WHERE user_id = $user_id");

// Ruaj token në DB
$insert = mysqli_query(
    $connection,
    "INSERT INTO password_resets (user_id, reset_token_hash, expires_at, created_at)
     VALUES ($user_id, '$tokenHash', '$expiresAt', NOW())"
);

if (!$insert) {
    http_response_code(500);
    echo json_encode([
        "error" => "Dështoi ruajtja e token-it",
        "details" => mysqli_error($connection)
    ]);
    exit;
}

// Dërgo email reset
$emailSent = sendEmailReset([
    "id"         => $user_id,
    "token"      => $rawToken,
    "user_email" => $user['email']
]);

echo json_encode([
    "success"    => true,
    "message"    => "Email was sent successfully.Please check your inbox.",
    "email_sent"=> $emailSent
]);
