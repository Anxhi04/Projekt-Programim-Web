<?php
require_once __DIR__ . "/../auth.php";
?>

    <!DOCTYPE html>
<html>
     <head>
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
         <link href="../css/nav.css" rel="stylesheet">
         <meta charset="utf-8">
         <meta content="width=device-width, initial-scale=1.0" name="viewport">
     </head>
     <body>
     <form method="post">
         <ul class="nav nav-pills mb-3 shadow" id="pills-tab" role="tablist">
             <li class="nav-item" role="presentation">
                 <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="submit" role="tab" aria-controls="pills-home" aria-selected="true">Beauty Center</button>
             </li>
             <li class="nav-item" role="presentation">
                 <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="submit" role="tab" aria-controls="pills-profile" aria-selected="false">Home🏚️</button>
             </li>
             <li class="nav-item" role="presentation">
                 <button class="nav-link" id="pills-contact-tab" name="book-service" data-bs-toggle="pill" data-bs-target="#pills-contact" type="submit" role="tab" aria-controls="pills-contact" aria-selected="false">Book Service📆</button>
             </li>
             <li class="nav-item ms-auto">
                 <?php if (isset($_SESSION["id"])): ?>
                     <a href="#" id="logoutLink" class="nav-link active login">
                         Logout
                     </a>
                 <?php else: ?>
                     <a href="/projekt/public/login.html" class="nav-link active login">
                         Login
                     </a>
                 <?php endif; ?>
             </li>

         </ul>
     </form>

     </body>
     <script>
         document.getElementById("logoutLink").addEventListener("click", async(e)=>{
             e.preventDefault();

             await fetch("http://localhost/projekt/public/logout.php", { credentials: "include" });

             window.location.href = "login.html";

         })
     </script>

</html>
<?php
    if(isset($_POST['book-service'])){
        header('location:book-service.php');
    }


?>