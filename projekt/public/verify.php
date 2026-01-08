<?php
require_once __DIR__ . '/../../db.php';

$user_id = $_GET['id'] ?? null;
$email_token = $_GET['token'] ?? null;

$status = 'error';
$message = 'Token is not valid or expired.';

if ($user_id && $email_token) {

    $query_user = "
        SELECT id, token_date 
        FROM users 
        WHERE id = '$user_id'
        AND email_token = '$email_token'
    ";

    $result_user = mysqli_query($connection, $query_user);

    if ($result_user && mysqli_num_rows($result_user) === 1) {

        $row_user = mysqli_fetch_assoc($result_user);

        $valid_datetime = strtotime($row_user['token_date']);
        $now = time();

        if ($now < $valid_datetime) {

            $query_update = "
                UPDATE users
                SET 
                    email_verified = 'yes',
                    email_verified_at = NOW()
                WHERE id = '$user_id'
            ";

            mysqli_query($connection, $query_update);

            $status = 'success';
            $message = 'Your email has been successfully verified!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <style>
        body {
            background: #f6f6f6;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        .verify-container {
            max-width: 420px;
            margin: 120px auto;
            background: #fff;
            border-radius: 14px;
            padding: 35px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0,0,0,.12);
        }

        .verify-container.success h1 {
            color: #2ecc71;
        }

        .verify-container.error h1 {
            color: #e74c3c;
        }

        .icon {
            font-size: 56px;
            margin-bottom: 15px;
        }

        p {
            font-size: 15px;
            color: #555;
            margin-top: 10px;
        }

        .btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 28px;
            border-radius: 8px;
            background: rgba(255,51,153,.9);
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .btn:hover {
            background: rgba(255,51,153,.7);
        }
    </style>
</head>

<body>

<div class="verify-container <?= $status ?>">
    <div class="icon">
        <?= $status === 'success' ? '✅' : '❌' ?>
    </div>

    <h1><?= $status === 'success' ? 'Email Verified' : 'Verification Failed' ?></h1>
    <p><?= $message ?></p>

    <a href="login.php" class="btn">Go to Login</a>
</div>

</body>
</html>


