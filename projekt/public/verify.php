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
            margin: 0;
            padding: 0;
        }

        .verify-container {
            max-width: 460px;
            margin: 110px auto;
            background: #fff;
            border-radius: 18px;
            padding: 38px 36px;
            text-align: center;
            box-shadow: 0 18px 55px rgba(0,0,0,.12);
            border: 1px solid rgba(255, 51, 153, .18);
            animation: fadeIn 0.6s ease forwards;
        }

        @keyframes fadeIn {
            0% {opacity: 0; transform: translateY(-20px);}
            100% {opacity: 1; transform: translateY(0);}
        }

        .verify-container.success h1 {
            color: #2ecc71;
        }

        .verify-container.error h1 {
            color: #e74c3c;
        }

        .icon {
            font-size: 64px;
            margin-bottom: 15px;
            width: 96px;
            height: 96px;
            line-height: 96px;
            border-radius: 50%;
            display: inline-block;
            background: #fff;
            border: 1px solid rgba(0,0,0,.08);
            box-shadow: 0 10px 20px rgba(0,0,0,.06);
        }

        .icon.success {
            color: #2ecc71;
        }

        .icon.error {
            color: #e74c3c;
        }

        h1 {
            font-size: 26px;
            margin: 12px 0;
        }

        p {
            font-size: 15px;
            color: #555;
            margin-top: 10px;
            line-height: 1.5;
        }

        .btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 30px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(255,51,153,.95), rgba(255,102,180,.85));
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            transition: transform .2s ease, box-shadow .2s ease;
            box-shadow: 0 12px 24px rgba(255, 51, 153, .22);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 30px rgba(255, 51, 153, .25);
        }
    </style>
</head>

<body>

<div class="verify-container <?= $status ?>">
    <div class="icon <?= $status ?>">
        <?= $status === 'success' ? '✔' : '✖' ?>
    </div>

    <h1><?= $status === 'success' ? 'Email Verified' : 'Verification Failed' ?></h1>
    <p><?= $message ?></p>

    <a href="login.php" class="btn">Go to Login</a>
</div>

</body>
</html>
