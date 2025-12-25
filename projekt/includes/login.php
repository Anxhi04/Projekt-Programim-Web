<!DOCTYPE html>
<html>
<head>
    <title>Log In</title>
</head>
<body>
<h3>
    Welcome!
</h3>
<p>
    Log in to book your appointments!
</p>
<form>
    <label>Email:
        <input type="email" id="email" placeholder="email">
        <span id="email_message"></span>
    </label>
    <br>
    <br>
    <label>Password:
        <input type="password" id="password" placeholder="password" required>
        <span id="password_message"></span>
    </label>
    <br>
    <input type="button" name="loginbtn" value="Login" onclick="login()">
    <p>Do not have an account? Register now</p>
     <input type="button" name="registerbtn" value="Register">
</form>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
//Validation of data
    function login(){
        var email = $("#email").val();
        var password = $("#password").val();
        var email_regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        var error = 0;
        //Validation of email
        if(!email_regex.test(email)){
            $("#email_message").text("E-mail nuk eshte i vendosur sakte");
            error++;
        }else{
            $("#email_message").text("");
        }
        //Validation of password
        if(!password){
            $("#password_message").text("Password should be filled");
        }else{
            $("#email_message").text("");
        }

    }

</script>
</body>
</html>




<?php
