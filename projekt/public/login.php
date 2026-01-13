<?php
require_once __DIR__ . '/../../db.php';
error_reporting(0); //Mos shfaq asnje gabim apo paralajmerim

if($_POST["action"] == "login"  ){
    //First we get data from front in backend
    $remember = !empty($_POST["remember_token"]); // true/false

    $email = mysqli_real_escape_string($connection, $_POST["email"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);
    $email_regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
    $succes=0; //ruan nese logohet apo jo perdoruesi
    $userId="NULL";
    $location=null;
    $statuscode=400;
    $message="login failed";
    $action="";//per loget ne db


    //Data validation backend
    //email validation
    if(!preg_match($email_regex, $email)){
        $message="invalid email";
        $action="login_failed_validation";
    }
    //password validation
    else if(empty($password)){
        $message="invalid password";
        $action="login_failed_validation";
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
                $action="login_blocked_active_lock";//na duhet per te ruajtur loget ne db
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
                $action="login_failed";
            }else{
                $action="login_success";
                $succes=1;
                $statuscode=200;
                $message="Login successful";
                //create sessionto save data of user
                session_start();
                $_SESSION["id"]=$user['id'];
                $_SESSION["name"]=$user['name'];
                $_SESSION["email"]=$user['email'];
                $_SESSION["role"]=$user['role'];

//                $location="/Projekt-Programim-Web/projekt/includes/home.php";
                $location="/Projekt-Programim-Web/projekt/includes/mainHome.php";

                if($user["role"]=="admin"){
                    $location="/Projekt-Programim-Web/projekt/admin.php";
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
        if ($action === "") $action="login_failed";
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
            $action="login_locked";
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
    //ruajtja e logeve ne db
    mysqli_query($connection,"INSERT INTO activity_logs(user_id, action , entity, ip_address, created_at)
                                     VALUES ($userId, '$action', 'users', '$ip_address', Now())");



    //response for frontend
    http_response_code($statuscode);
    if($succes==1){
        //nese nuk eshte zgjedhur remember me dhe ka token t vjeter
        if(!$remember && !empty($_COOKIE["remember_token"])){
            $old_hash=hash("sha256", $_COOKIE["remember_token"]);
            mysqli_query($connection, "
            UPDATE remember_tokens
                SET revoked_at=NOW()
                WHERE token_hash='$old_hash'");
            //fshi cookien
            setcookie("remember_token", "", time() - 3600, "/");
        }
        //nese eshte zgjedhur remember me
        if($remember){
            //krijojme token
            $token= bin2hex(random_bytes(32));
            $token_hash= hash("sha256", $token);
            $expires = date("Y-m-d H:i:s", strtotime("+30 days"));
            //update token e vjeter
            mysqli_query($connection,
                "UPDATE remember_tokens 
                   SET revoked_at=NOW()
                   WHERE user_id=$userId
                   AND revoked_at IS NULL");

            //ruaj token e ri
            mysqli_query($connection,
                "INSERT INTO remember_tokens (user_id, token_hash, expires_at, created_at, revoked_at)
                            VALUES($userId, '$token_hash', '$expires', NOW(), NULL)");

            //vendos cookie
            setcookie("remember_token", $token, [
                "expires" => time() + 60*60*24*30,
                "path" => "/Projekt-Programim-Web/projekt/",
                "secure" => false,
                "httponly" => true,
                "samesite" => "Lax",
            ]);

        }

        echo json_encode(["status"=>200,
                          "message"=>$message,
                           "redirect"=>$location]);

    }else{
        echo json_encode(["status" => $statuscode, "message" => $message]);
    }
    exit;
}

?>

<!--/**************************************************************-->
<!--*   STILIZIMI DHE JS I FAQES LOGIN QE TE HAPEN EDHE NGA XAMPP-->
<!--**************************************************************/-->

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--    &lt;!&ndash;    <link rel="stylesheet" href="/projekt/includes/partials/header.php">&ndash;&gt;-->
    <link rel="stylesheet" href="/Projekt-Programim-Web/projekt/includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Projekt-Programim-Web/projekt/includes/css/custom.css">

    <title>Document</title>
</head>
<body>
<!-- Login 9 - Bootstrap Brain Component -->

<section class="bg-primary py-3 py-md-5 py-xl-8">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-12 col-md-6 col-xl-7">
                <div class="d-flex justify-content-center text-bg-primary">
                    <div class="col-12 col-xl-9">
                        <img class="img-fluid rounded mb-4" loading="lazy" src="./assets/img/bsb-logo-light.svg" width="245" height="80" alt="BootstrapBrain Logo">
                        <hr class="border-primary-subtle mb-4">
                        <h2 class="h1 mb-4">WELCOME</h2>
                        <p class="lead mb-5">Log in to your account to access all features </p>
                        <div class="text-endx">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-grip-horizontal" viewBox="0 0 16 16">
                                <path d="M2 8a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-5">
                <div class="card border-0 rounded-4">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4" style="color: grey">
                                    <h3>Sign in</h3>
                                    <p>Don't have an account? <a href="register.php" class="link-primary text-decoration-none">Sign up</a></p>
                                </div>
                            </div>
                        </div>
                        <form action="#!">
                            <div class="row gy-3 overflow-hidden">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                                        <label for="email" class="form-label">Email</label>
                                        <span id="email_message"></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                                        <label for="password" class="form-label">Password</label>
                                        <span id="password_message"></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check" >
                                        <input class="form-check-input" type="checkbox" value=1" name="remember_me" id="remember_me">
                                        <label class="form-check-label text-secondary" for="remember_me">
                                            Remember me
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-lg" type="button" onclick="login(event)">Log in now</button>
                                        <div id="login_status" style="margin-top:10px;"></div>

                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-4">
                                    <a href="/Projekt-Programim-Web/projekt/public/reset_pass.php" class="link-primary text-decoration-none" >Forgot password</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p class="mt-4 mb-4">Or continue with</p>
                                <div class="d-flex gap-2 gap-sm-3 justify-content-centerX">
                                    <a href="#!" class="btn btn-outline-danger bsb-btn-circle bsb-btn-circle-2xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                                            <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z" />
                                        </svg>
                                    </a>
                                    <a href="#!" class="btn btn-outline-primary bsb-btn-circle bsb-btn-circle-2xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                        </svg>
                                    </a>
                                    <a href="#!" class="btn btn-outline-dark bsb-btn-circle bsb-btn-circle-2xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-apple" viewBox="0 0 16 16">
                                            <path d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516.024.034 1.52.087 2.475-1.258.955-1.345.762-2.391.728-2.43Zm3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422.212-2.189 1.675-2.789 1.698-2.854.023-.065-.597-.79-1.254-1.157a3.692 3.692 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56.244.729.625 1.924 1.273 2.796.576.984 1.34 1.667 1.659 1.899.319.232 1.219.386 1.843.067.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758.347-.79.505-1.217.473-1.282Z" />
                                            <path d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516.024.034 1.52.087 2.475-1.258.955-1.345.762-2.391.728-2.43Zm3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422.212-2.189 1.675-2.789 1.698-2.854.023-.065-.597-.79-1.254-1.157a3.692 3.692 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56.244.729.625 1.924 1.273 2.796.576.984 1.34 1.667 1.659 1.899.319.232 1.219.386 1.843.067.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758.347-.79.505-1.217.473-1.282Z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    //Validation of data
    function login(e){
        e.preventDefault();
        const remember= document.getElementById("remember_me").checked;
        var email = $("#email").val();
        var password = $("#password").val();
        var email_regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        var error = 0;
        //Validation of email
        if(!email_regex.test(email) || !email.trim()){
            $("#email_message").text("E-mail nuk eshte i vendosur sakte");
            error++;
        }else{
            $("#email_message").text("");
        }
        //Validation of password
        if(!password.trim()){
            $("#password_message").text("Password should be filled");
            error++;
        }else{
            $("#password_message").text("");
        }

        //Create a form data in order to send data to php

        var data = new FormData();
        data.append("action", "login");
        data.append("email", email);
        data.append("password", password);
        if (remember) {
            data.append("remember_me", "1");
        }


        //Send data on backend
        if(error==0){
            fetch("/Projekt-Programim-Web/projekt/public/login.php",{
                method:"POST",
                body:data
            }).then(response=>response.json()).then(response=> {
                if (response.status == 200) {
                    window.location.href = response.redirect;
                    return;
                }
                console.log("BACKEND RESPONSE:", response);

                if (response.status == 423 && response.locked_until) {
                    const lockedUntil = new Date(response.locked_until.replace(' ', 'T'));
                    const now = new Date();
                    const min_left = Math.max(0, Math.ceil((lockedUntil - now) / 60000));
                    $("#login_status").text(`Je i/e bllokuar. Provo serish pas ${min_left} minutash.`);
                    return;

                }
                $("#login_status").text(response.message || "Login failed");
            })
                .catch(()=> $("#login_status").text("Gabim ne server. Provo serish."));

        }
    }
</script>

</body>
</html>