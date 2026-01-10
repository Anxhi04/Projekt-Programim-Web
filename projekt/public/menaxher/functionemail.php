<?php

use PHPMailer\PHPMailer\PHPMailer\src\Exception;
use PHPMailer\PHPMailer\PHPMailer\src\PHPMailer;

require_once __DIR__ . '/../../../PHPMailer/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../../../PHPMailer/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../../../PHPMailer/PHPMailer/src/SMTP.php';

function sendEmail($data){

    $config=require __DIR__ . '/../../../config/url.php';

    $verifyUrl =
        $config['BASE_URL'] .
        '/verify.php?id=' . urlencode($data['id']) .
        '&token=' . urlencode($data['token']);

    $mail = new PHPMailer(true);
    $mail->Subject = 'Reservation status';


$text = "
        <div style='font-family: Arial, sans-serif; background-color:#f9f9f9; padding:20px; border-radius:10px; text-align:center;'>
    <h2 style='color:#FF69B4;'>Your reservation was {$data['code']}</h2>
    <p style='font-size:16px; color:#333;'>Thank you for using <strong>GlamBook</strong>.</p>
</div>
    ";



    $text = str_replace('{{VERIFY_URL}}', $verifyUrl, $text);

    try {
        //Server settings
        $mail->SMTPDebug = false;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'verifyGlamBook@gmail.com';                     //SMTP username
        $mail->Password = 'hwyd tpsk dwzw clqm';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('verifyGlamBook@gmail.com', 'No reply');
//        $mail->addAddress('emadanipolli@gmail.com', 'Emada');     //Add a recipient
        $mail->addAddress($data["user_email"]);               //Name is optional
//    $mail->addReplyTo('info@example.com', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

        //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Verify your email address';
        $mail->Body = $text;
//    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}




