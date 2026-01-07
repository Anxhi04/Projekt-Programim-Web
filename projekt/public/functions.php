<?php

use PHPMailer\PHPMailer\PHPMailer\src\Exception;
use PHPMailer\PHPMailer\PHPMailer\src\PHPMailer;

require_once __DIR__ . '/../../PHPMailer/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../../PHPMailer/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../../PHPMailer/PHPMailer/src/SMTP.php';

function sendEmail($data){

    $mail = new PHPMailer(true);
    $text = '<!doctypehtml><html xmlns="http://www.w3.org/1999/xhtml"><head><meta content="width=device-width"name="viewport"><meta content="text/html; charset=UTF-8"http-equiv="Content-Type"><title>Alerts e.g. approaching your limit</title><style>*{margin:0;padding:0;font-family:"Helvetica Neue",Helvetica,Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px}img{max-width:100%}body{-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100%!important;height:100%;line-height:1.6}table td{vertical-align:top}body{background-color:#f6f6f6}.body-wrap{background-color:#f6f6f6;width:100%}.container{display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important}.content{max-width:600px;margin:0 auto;display:block;padding:20px}.main{background:#fff;border:1px solid #e9e9e9;border-radius:3px}.content-wrap{padding:20px}.content-block{padding:0 0 20px}.header{width:100%;margin-bottom:20px}.footer{width:100%;clear:both;color:#999;padding:20px}.footer a{color:#999}.footer a,.footer p,.footer td,.footer unsubscribe{font-size:12px}h1,h2,h3{font-family:"Helvetica Neue",Helvetica,Arial,"Lucida Grande",sans-serif;color:#000;margin:40px 0 0;line-height:1.2;font-weight:400}h1{font-size:32px;font-weight:500}h2{font-size:24px}h3{font-size:18px}h4{font-size:14px;font-weight:600}ol,p,ul{margin-bottom:10px;font-weight:400}ol li,p li,ul li{margin-left:5px;list-style-position:inside}a{color:rgba(255,51,153,.63);text-decoration:underline}.btn-primary{text-decoration:none;color:#fff;background-color:rgba(255,51,153,.9);border:none;padding:12px 30px;line-height:normal;font-weight:700;text-align:center;cursor:pointer;display:inline-block;border-radius:6px;text-transform:capitalize}.btn-primary:hover{background-color:rgba(255,51,153,.63)}.last{margin-bottom:0}.first{margin-top:0}.aligncenter{text-align:center}.alignright{text-align:right}.alignleft{text-align:left}.clear{clear:both}.alert{font-size:20px;font-weight:700;color:#fff;font-weight:500;padding:20px;text-align:center;border-radius:3px 3px 0 0}.alert a{color:#fff;text-decoration:none;font-weight:500;font-size:16px}.alert.alert-warning{background:rgba(255,51,153,.63)}.alert.alert-bad{background:rgba(255,51,153,.63)}.alert.alert-good{background:rgba(255,51,153,.63)}.invoice{margin:40px auto;text-align:left;width:80%}.invoice td{padding:5px 0}.invoice .invoice-items{width:100%}.invoice .invoice-items td{border-top:#eee 1px solid}.invoice .invoice-items .total td{border-top:2px solid #333;border-bottom:2px solid #333;font-weight:700}@media only screen and (max-width:640px){h1,h2,h3,h4{font-weight:600!important;margin:20px 0 5px!important}h1{font-size:22px!important}h2{font-size:18px!important}h3{font-size:16px!important}.container{width:100%!important}.content,.content-wrap{padding:10px!important}.invoice{width:100%!important}}</style></head><body><table class="body-wrap"><tr><td></td><td class="container"width="600"><div class="content"><table cellpadding="0"cellspacing="0"width="100%"class="main"style="border-radius:12px;overflow:hidden"><tr><td class="alert alert-good"><br>Verify your email address</td></tr><tr><td class="content-wrap"><table cellpadding="0"cellspacing="0"width="100%"><tr><td class="aligncenter content-block">Please click to the button below to verify your email address.<h1>'.$data["code"].'</h1></td></tr><tr><td class="aligncenter content-block"><a href="http://localhost:8081/Projekt-Programim-Web/projekt/public/verify.php?id='.$data['id'].'&token='.$data["token"].'"class="btn-primary" style="color:#ffffff !important; text-decoration:none;">Verify</a></td></tr><tr><td class="aligncenter content-block" style="font-size:12px">Thanks for choosing GlamBook <3!</td></tr></table></td></tr></table><div class="footer"><table width="100%"><tr><td class="aligncenter content-block"><a href="#">GlamBook</a> Tirana,Albania</td></tr></table></div></div></td><td></td></tr></table></body></html>';

    try {
        //Server settings
        $mail->SMTPDebug = false;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'verifyGlamBook@gmail.com';                     //SMTP username
        $mail->Password = 'vogp shwt leod euox';                               //SMTP password
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

//i sakte


