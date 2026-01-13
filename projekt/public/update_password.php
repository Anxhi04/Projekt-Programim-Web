<?php

// update_password.php
require_once __DIR__ . '/../../db.php';

header('Content-Type: application/json');

// Lexo JSON input
$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'] ?? null;
$token = $data['token'] ?? null;
$password = $data['password'] ?? null;
$confirm = $data['confirm_password'] ?? null;

if (!$id || !$token || !$password || !$confirm) {
    http_response_code(400);
    echo json_encode([
        "error" => "Missing data",
        "received" => $data
    ]);
    exit;
}

$id = (int)$id;

if ($password !== $confirm) {
    http_response_code(400);
    echo json_encode(["error" => "Passwords do not match"]);
    exit;
}

// Hash token që erdhi nga linku
$tokenHash = hash('sha256', $token);

// 1) gjej reset record valid (jo i përdorur + jo i skaduar)
$stmt = $connection->prepare("
    SELECT id, user_id, expires_at, used_at
    FROM password_resets
    WHERE user_id = ?
      AND reset_token_hash = ?
      AND used_at IS NULL
    LIMIT 1
");
$stmt->bind_param("is", $id, $tokenHash);
$stmt->execute();
$res = $stmt->get_result();
$reset = $res->fetch_assoc();

if (!$reset) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid or already used reset token"]);
    exit;
}

// kontrollo expiry
if (strtotime($reset['expires_at']) < time()) {
    http_response_code(400);
    echo json_encode(["error" => "Token expired. Please request a new reset link."]);
    exit;
}

// 2) update password te users
$newHash = password_hash($password, PASSWORD_DEFAULT);

$stmt2 = $connection->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
$stmt2->bind_param("si", $newHash, $id);

if (!$stmt2->execute()) {
    http_response_code(500);
    echo json_encode([
        "error" => "Failed to update password",
        "details" => $connection->error
    ]);
    exit;
}

// 3) shëno token si i përdorur
$resetId = (int)$reset['id'];
$stmt3 = $connection->prepare("UPDATE password_resets SET used_at = NOW() WHERE id = ?");
$stmt3->bind_param("i", $resetId);

if (!$stmt3->execute()) {
    http_response_code(500);
    echo json_encode([
        "error" => "Password updated but failed to mark token as used",
        "details" => $connection->error
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "message" => "Password changed successfully!"
]);
