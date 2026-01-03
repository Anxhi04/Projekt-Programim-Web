<?php
require_once __DIR__ . '/../../db.php';

if($_POST["action"]=="book"){
    session_start();
    $_SESSION["id"]=$user["id"];
    //get the data from frontend
    $service =mysqli_real_escape_string($connection, $_POST["service"]);
    $date =mysqli_real_escape_string($connection, $_POST["date"]);
    $time =mysqli_real_escape_string($connection, $_POST["time"]);
    $price =mysqli_real_escape_string($connection, $_POST["price"]);
    //insert the data into db



}
?>