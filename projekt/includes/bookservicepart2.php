<?php
require_once __DIR__ . '/../../db.php';
session_start();
error_reporting(E_ALL);


if($_POST["action"]=="book"){
    echo "book";
    $user_id= $_SESSION["id"];
    //get the data from frontend
    $service =mysqli_real_escape_string($connection, $_POST["service_id"]);
    $date =mysqli_real_escape_string($connection, $_POST["date"]);
    $time =mysqli_real_escape_string($connection, $_POST["time"]);
    $created_at = mysqli_real_escape_string($connection, $_POST["createdAt"]);
    //insert the data into db
    $result= mysqli_query($connection, "
    INSERT INTO reservations(client_user_id, service_id, date, start_time, status, created_at)
    VALUES('$user_id' , '$service','$date','$time', 'pending', '$created_at')");

    if($result){
        echo "success";
    }else{
        echo "error" . mysqli_error($connection);
    }



}
?>