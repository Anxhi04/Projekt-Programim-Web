<?php
require_once __DIR__ . '/../../db.php';

$firstname = trim($_POST['firstName'] ?? '');
$lastname  = trim($_POST['lastName'] ?? '');
$email     = trim($_POST['email'] ?? '');
$password  = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';

$email_regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
$alpha_regex = "/^[a-zA-Z]{3,40}$/";

$email_code = rand(10000, 99999);
$email_token = password_hash($email_code, PASSWORD_BCRYPT);
$valid_date = date('Y-m-d H:i:s', strtotime(' +5 minutes '));

// VALIDIM BACKEND
//validimi i emrit
if (!preg_match($alpha_regex, $firstname)) {
    http_response_code(201);
    $response = array("message" => "Name must be aphabetic at least 3 letters.");
    echo json_encode($response);
    exit;
}
//validimi i mbiemrit
if (!preg_match($alpha_regex, $lastname)) {
    http_response_code(201);
    $response = array("message" => "Surname must be aphabetic at least 3 letters.");
    echo json_encode($response);
    exit;
}
// VALIDIM I EMAILIT
if (!preg_match($email_regex, $email)) {
    http_response_code(201);
    $response = array("message" => "E-Mail format is not allowed");
    echo json_encode($response);
    exit;
}
// VALIDIM I PASSWORDIT
if (empty($password)) {
    http_response_code(201);
    $response = array("message" => "Password can not be empty");
    echo json_encode($response);
    exit;
}

// VALIDIM I CONFIRM PASSWORD
if ($password != $confirmPassword) {
    http_response_code(201);
    $response = array("message" => "Confirm password must be equal to password");
    echo json_encode($response);
    exit;
}

// kontrolloj nese email ekziston ne db
$check = mysqli_prepare($connection, "SELECT id FROM users WHERE email = ?");
mysqli_stmt_bind_param($check, "s", $email);
mysqli_stmt_execute($check);
mysqli_stmt_store_result($check);

if (mysqli_stmt_num_rows($check) > 0) {
    exit("Email already exists");
}

mysqli_stmt_close($check);

//insert ne db
$query = "INSERT INTO users (firstname, lastname, email, password_hash, created_at)
          VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($connection, $query);

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$createdAt = date("Y-m-d H:i:s");

mysqli_stmt_bind_param(
    $stmt,
    "sssss",
    $firstname,
    $lastname,
    $email,
    $hashedPassword,
    $createdAt
);

if (mysqli_stmt_execute($stmt)) {
    http_response_code(200);
    echo json_encode([
        "success" => true,
        "message" => "User registered successfully"
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Database error"
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($connection);
exit;