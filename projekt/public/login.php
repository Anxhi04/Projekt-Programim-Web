<?php
require_once __DIR__ . '/../../db.php';
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
        exit;
    }
    //Check if there is someone with that email on db or not
    $email_check= "Select * from users where email='$email'";
    $result = mysqli_query($connection, $email_check);
    if(!$result){
        http_response_code(500);
        //there are 3 categories of errors bcs one is for the users and others for the programer
        $response = array("status"=>500,
                           "message"=> "There is an error on db",
                           "error"=> mysqli_error($connection),
                           "error_number"=>mysqli_errno($connection));
        echo json_encode($response);
        exit;
    }
    //If there isnt any user with that email
    if(mysqli_num_rows($result) == 0){
        http_response_code(400);
        $response= array("status"=>400,
            "message"=>"there is not any user with this email");
        echo json_encode($response);
        exit;
    }
    $result_email_check = mysqli_fetch_assoc($result);

    //if there is a user with that email we should check the password
    if(!password_verify($password, $result_email_check["password_hash"])){
        http_response_code(400);
        $response = array("message"=> "Wrong password");
        echo json_encode($response);
        exit;
    }
    //nese kemi succses
    http_response_code(200);
    echo json_encode(["status" => 200, "message" => "Login successful"]);
    exit;
}


?>