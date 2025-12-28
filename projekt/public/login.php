<?php
require_once('db.php');
error_reporting(0); //Mos shfaq asnje gabim apo paralajmerim

if($_POST["action"] == "login"){
    //First we get data from front in backend
    $email = mysqli_real_escape_string($connection, $_POST["email"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);
    $email_regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

    //Data validation backend
    //email validation
    if(!preg_match($email_regex, $email)){
        http_response_code(400);
        $response = array("message"=> "Invalid email");
        echo json_encode($response);
        exit;
    }
    //password validation
    if(empty($password)){
        http_response_code(400);
        $response = array("message"=>"Password required");
        echo json_encode($response);
        exit
    }
}


?>