<?php
use PHPMailer\PHPMailer\PHPMailer\src\Exception;
use PHPMailer\PHPMailer\PHPMailer\src\PHPMailer;

require_once __DIR__ . '/../../PHPMailer/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../../PHPMailer/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../../PHPMailer/PHPMailer/src/SMTP.php';

function sendEmailReset($data){

    $config=require __DIR__ . '/../../config/url.php';
    $mailConfig=require __DIR__ . '/../../config/mailer.php';

    $resetUrl =
        $config['BASE_URL'] .
        '/reset_password.php?id=' . urlencode($data['id']) .
        '&token=' . urlencode($data['token']);

    $mail = new PHPMailer(true);

    $text = '<html><body>
        <h2>Password Reset Request</h2>
        <p>You requested to reset your password. Click the button below:</p>
        <p><a href="{{RESET_URL}}" style="background:#007bff;color:white;padding:10px 20px;border-radius:5px;text-decoration:none">Reset Password</a></p>
        <p>If you didn\'t request this, you can ignore this email.</p>
    </body></html>';

    $text = str_replace('{{RESET_URL}}', $resetUrl, $text);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'verifyGlamBook@gmail.com';
        $mail->Password = 'hwyd tpsk dwzw clqm';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('verifyGlamBook@gmail.com', 'No reply');
        $mail->addAddress($data["user_email"]);
        $mail->isHTML(true);
        $mail->Subject = 'Reset your password';
        $mail->Body = $text;

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}
