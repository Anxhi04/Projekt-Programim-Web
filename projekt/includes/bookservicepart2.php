<?php
require_once __DIR__ . '/../../db.php';
session_start();
error_reporting(E_ALL);


if($_POST["action"]=="book") {
    $statuscode = 200;
    $message = "";

    $user_id = $_SESSION["id"] ?? null;
    if(!$user_id){
        $statuscode = 300;
        $message = "Login to make a book";
        echo json_encode([
            "status" => $statuscode,
            "message" => $message
        ]);
        exit;
    }
    //get the data from frontend
    $service = mysqli_real_escape_string($connection, $_POST["service_id"]);
    $date = mysqli_real_escape_string($connection, $_POST["date"]);
    $time = mysqli_real_escape_string($connection, $_POST["time"]);
    $created_at = mysqli_real_escape_string($connection, $_POST["createdAt"]);

    //kontrollo nese ka persona qe kane ber ebooking ne te njejtin orar me pare
    $check = mysqli_query($connection, "
                                 Select * from reservations
                                 where service_id='$service' and date='$date' and start_time='$time'");

    if (mysqli_num_rows($check) > 0) {
        $statuscode = 300;
        $message = "This time is already booked for this service";
        echo json_encode([
            "status" => $statuscode,
            "message" => $message
        ]);
        exit;
    }

    //insert the data into db
    $result = mysqli_query($connection, "
    INSERT INTO reservations(client_user_id, service_id, date, start_time, status, created_at)
    VALUES('$user_id' , '$service','$date','$time', 'pending', '$created_at')");


    echo json_encode([
        "status" => $statuscode,
        "message" => $message
    ]);
    exit;
}

?>