<?php
require_once __DIR__ . '/../../db.php';
error_reporting(0); //Mos shfaq asnje gabim apo paralajmerim

if($_POST["action"] == "login"){
    //First we get data from front in backend
    $email = mysqli_real_escape_string($connection, $_POST["email"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);
    $email_regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
    $succes=0; //ruan nese logohet apo jo perdoruesi
    $userId="NULL";
    $location=null;
    $statuscode=400;
    $message="login failed";


    //Data validation backend
    //email validation
    if(!preg_match($email_regex, $email)){
        $message="invalid email";
    }
    //password validation
    else if(empty($password)){
        $message="invalid password";
    }else{
        //Check if there is someone with that email on db or not
        $email_check= "Select * from users where email='$email'";
        $result = mysqli_query($connection, $email_check);
        if(!$result){
            http_response_code(500);
            $statuscode=500;
            $message="There isb an error in db";
        }
        //If there isnt any user with that email
        else if(mysqli_num_rows($result) == 0){
            $message="There is no user with this email in db";
        }else{
            $user = mysqli_fetch_assoc($result);
            $userId= (int)$user["id"];
            //per kerkesen qe pas 7 tentativash te bllokohet
            //ne momentin qe useri eshte i bllokuar nuk kontrrollohet passwordi
            if(!empty($user["locked_until"]) && strtotime($user["locked_until"])>time()){
                $statuscode= 423;//locked
                $message="Account locked until" . $user["locked_until"];
                //regjistrojme tentativen
                mysqli_query($connection, "INSERT INTO login_attempts (user_id, email_entered, ip_address, success, attempt_time)
                                                  VALUES ($userId, '$email', '$ip_address', 0, Now())");
                http_response_code($statuscode);
                echo json_encode([
                    "status" => $statuscode,
                    "message" => $message,
                    "locked_until" => $user["locked_until"],
                ]);
                exit;
            }

            //if there is a user with that email we should check the password
            if(!password_verify($password, $user["password_hash"])){
                $message="Wrong passworrd";
            }else{
                $succes=1;
                $statuscode=200;
                $message="Login successful";
                //create sessionto save data of user
                session_start();
                $_SESSION["id"]=$user['id'];
                $_SESSION["name"]=$user['name'];
                $_SESSION["email"]=$user['email'];
                $_SESSION["role"]=$user['role'];

                $location="/projekt/includes/home.php";

                if($user["role"]=="admin"){
                    $location="/projekt/admin.php";
                }
            }

        }

    }

    //put the user attempt to login in loginattempts table
    mysqli_query($connection,
                "Insert into login_attempts(user_id, email_entered, ip_address, success, attempt_time)
                        values($userId, '$email' , '$ip_address', $succes, NOW())");
    //nese jane bere 7 tentativa te gabuara
    if($succes==0 && $userId!=="NULL"){
        //numerojme nese jane bere 7 apo jo
        $count_failed= mysqli_query($connection,
        "SELECT COUNT(*) AS failed
        FROM login_attempts
        WHERE user_id=$userId
        AND success=0
        AND attempt_time>=(NOW() - INTERVAL 30 MINUTE)");

        $row = mysqli_fetch_assoc($count_failed);
        $count=(int)$row["failed"];

        if($count>=7){
            mysqli_query($connection,
                "Update users
        set locked_until=(NOW() + INTERVAL 30 MINUTE)
        WHERE id=$userId");
            $statuscode = 423;
            $message = "Too many failed attempts. Locked for 30 minutes.";
        }

    }
    //nese login eshte sukses do bejme reset attempts qe ishin fail
    if ($succes == 1 && $userId !== "NULL") {
        mysqli_query($connection, "DELETE FROM login_attempts WHERE user_id = $userId AND success = 0");
        mysqli_query($connection, "UPDATE users SET locked_until = NULL WHERE id = $userId");
    }


    //response for frontend
    http_response_code($statuscode);
    if($succes==1){
        echo json_encode(["status"=>200,
                          "message"=>$message,
                           "redirect"=>$location]);

    }else{
        echo json_encode(["status" => $statuscode, "message" => $message]);
    }
    exit;

}


?>