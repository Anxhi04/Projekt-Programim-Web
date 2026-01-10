<?php
require_once __DIR__ . "/../auth.php";



$script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$base = preg_replace('#/(public|includes)/.*$#', '', $script); // nxjerr /.../projekt

if (isset($_POST['book-service'])) {
    header('location:/Projekt-Programim-Web/projekt/includes/book-service.php');
}


?>
<script>
    const BASE_URL = "<?= $base ?>";
</script>

    <!DOCTYPE html>
<html>
     <head>
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
         <meta charset="utf-8">
         <meta content="width=device-width, initial-scale=1.0" name="viewport">
         <style>


             body.homepage .nav {
                 position: fixed;
                 top: 0;
                 left: 0;
                 width: 100%;
                 z-index: 9999;
             }


             .nav-pills .nav-link.active {
                 background-color: pink;
                 color: white;
             }
             .nav-pills .nav-item:not(:first-child) .nav-link {
                 color: pink;
             }
             .nav-pills button{
                 gap: 1%;
                 margin: 2px;
             }
             .nav-pills button:hover{
                 background: rgba(236, 206, 211, 0.71);
             }
             .nav-pills .nav-link.active.login:hover,
             .nav-pills .nav-item .nav-link:hover{
                 color: deeppink;
             }

             .nav-pills .nav-link.active.login{
                 color: white;
             }
         </style>
     </head>
     <body>
     <form method="post">
         <ul class="nav nav-pills mb-3 shadow" id="pills-tab" role="tablist">
             <li class="nav-item" role="presentation">
                 <button class="nav-link active" id="homebtn" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">GlamBook</button>
             </li>
             <li class="nav-item" role="presentation">
                 <button class="nav-link" id="homebtn2" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Home🏚️</button>
             </li>
             <li class="nav-item" role="presentation">
                 <button class="nav-link"  name="book-service" id="book-service" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Book Service📆</button>
             </li>
             <li class="nav-item ms-auto">
                 <?php if (isset($_SESSION["id"])): ?>
                     <a href="#" id="logoutLink" class="nav-link active login">
                         Logout
                     </a>
                 <?php else: ?>
                     <a href="Projekt-Programim-Web/projekt/public/login.html" class="nav-link active login">
                         Login
                     </a>
                 <?php endif; ?>
             </li>

         </ul>
     </form>

     </body>
     <script>
         document.addEventListener('DOMContentLoaded', () => {

             const logoutLink = document.getElementById('logoutLink');
             if (logoutLink) {
                 logoutLink.addEventListener('click', (e) => {
                     e.preventDefault();
                     // më thjesht: shko direkt te logout.php (pa fetch)
                     window.location.href =BASE_URL + "/public/logout.php";
                 });
             }

             const bookbtn = document.getElementById('book-service');
             if (bookbtn) {
                 bookbtn.addEventListener('click', (e) => {
                     e.preventDefault();
                     window.location.href =BASE_URL +"/includes/book-service.php";
                 });
             }
             const homebtn = document.getElementById('homebtn');
                if (homebtn) {
                    homebtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        window.location.href =BASE_URL +"/includes/mainHome.php";
                    });
                }
                const homebtn2 = document.getElementById('homebtn2');
                if (homebtn2) {
                    homebtn2.addEventListener('click', (e) => {
                        e.preventDefault();
                        window.location.href =BASE_URL +"/includes/home.php";
                    });
                }
         });

     </script>


</html>

