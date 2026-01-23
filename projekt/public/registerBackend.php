<?php

require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/functions.php';


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

//KONTROLLOJME NQS EMAILI NDODHET NE DB
$query_check = "SELECT id
                    FROM users
                    WHERE email = '" . $email . "';";

$result_check = mysqli_query($connection, $query_check);

if (!$result_check) {
    http_response_code(202);
    $response = array(
        "message" => "There is an error on Database",
        "error" => mysqli_error($connection),
        "error_number" => mysqli_errno($connection)
    );
    echo json_encode($response);
    exit;
}

// NËSE EKZISTON USER ME KËTË EMAIL
if (mysqli_num_rows($result_check) > 0) {
    http_response_code(201);
    $response = array("message" => "There is a user with that E-Mail");
    echo json_encode($response);
    exit;
}


//INSERT USER NE DB
$query_insert = "INSERT INTO users SET
                     firstname = '" . $firstname . "',
                     lastname = '" . $lastname . "',
                     email = '" . $email . "',
                     email_code = '" . $email_code . "',
                     code_date = '" . $valid_date . "',
                     email_token = '" . $email_token . "',
                     token_date = '" . $valid_date . "',
                     password_hash = '" . password_hash($password, PASSWORD_BCRYPT) . "',
                     created_at = '" . date("Y-m-d H:i:s") . "' ";

$result_insert = mysqli_query($connection, $query_insert);

// KONTROLL GABIMI NË INSERT
if (!$result_insert) {
    http_response_code(202);
    $response = array(
        "message" => "There is an error on Database",
        "error" => mysqli_error($connection),
        "error_number" => mysqli_errno($connection)
    );
    echo json_encode($response);
    exit;
}

/**
 * Send E-Mail to user to verify his E-Mail address
 */

$user_id = mysqli_insert_id($connection);

$data['code'] = $email_code;
$data['id'] = $user_id;
$data['token'] = $email_token;
$data['user_email'] = $email;


$email_sent = sendEmail($data);

http_response_code(200);
$response = array(
    "success" => true,
    "message" => "User registered successfully. Please verify your email.",
    "location" => "login.php"
);
echo json_encode($response);
exit;


