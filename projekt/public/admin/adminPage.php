<?php
require_once __DIR__ . "/../../includes/guard.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <link rel="shortcut icon" href="dist/assets/compiled/svg/favicon.svg" type="image/x-icon">

    <link rel="stylesheet" href="dist/assets/compiled/css/app.css">
    <link rel="stylesheet" href="dist/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="dist/assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="dist/assets/compiled/css/pinkOnly.css">
</head>

<body>
<script src="dist/assets/static/js/initTheme.js"></script>

<div id="app">
    <!-- SIDEBAR -->
    <div id="sidebar">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="logo">
                        <a href="adminPage.php">
                            <img src="/Projekt-Programim-Web/projekt/public/assets/logo/GlamBookLogo.png" alt="Logo" class="logo-img">
                        </a>
                    </div>

                    <!-- TOGGLE REMOVED -->

                    <div class="sidebar-toggler x">
                        <a href="#" class="sidebar-hide d-xl-none d-block">
                            <i class="bi bi-x bi-middle"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="sidebar-menu">
                <ul class="menu">
                    <li class="sidebar-title">ADMIN PANEL</li>

                    <li class="sidebar-item active">
                        <a href="adminPage.php" class="sidebar-link">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="usersAdm.php" class="sidebar-link">
                            <i class="bi bi-people-fill"></i>
                            <span>Users</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="businessesAdm.php" class="sidebar-link">
                            <i class="bi bi-building"></i>
                            <span>Businesses</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="service-categories.php" class="sidebar-link">
                            <i class="bi bi-tags-fill"></i>
                            <span>Service Categories</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="bookingsAdm.php" class="sidebar-link">
                            <i class="bi bi-calendar-check-fill"></i>
                            <span>Bookings</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="paymentsAdm.php" class="sidebar-link">
                            <i class="bi bi-credit-card-fill"></i>
                            <span>Payments</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="reviews.php" class="sidebar-link">
                            <i class="bi bi-star-fill"></i>
                            <span>Reviews</span>
                        </a>
                    </li>

                    <li class="sidebar-title">SYSTEM</li>

                    <li class="sidebar-item">
                        <a href="/Projekt-Programim-Web/projekt/public/login.php" class="sidebar-link">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- MAIN -->
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Profile Statistics</h3>
        </div>

        <div class="page-content">
            <section class="row">
                <!-- LEFT CONTENT -->
                <div class="col-12 col-lg-9">
                    <!-- STATS -->
                    <div class="row">
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                    <h6 class="text-muted">Guests</h6>
                                    <h6 class="font-extrabold mb-0">112.000</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                    <h6 class="text-muted">Registered Users</h6>
                                    <h6 class="font-extrabold mb-0">183.000</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                    <h6 class="text-muted">Businesses</h6>
                                    <h6 class="font-extrabold mb-0">80.000</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                    <h6 class="text-muted">Services Category</h6>
                                    <h6 class="font-extrabold mb-0">112</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PROFILE VISIT CHART -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4>Profile Visit</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDEBAR -->
                <div class="col-12 col-lg-3">
                    <!-- PROFILE CARD -->
<!--                    <div class="card">-->
<!--                        <div class="card-body py-4 px-4">-->
<!--                            <div class="d-flex align-items-center">-->
<!--                                <div class="avatar avatar-xl">-->
<!--                                    <img src="./assets/compiled/jpg/1.jpg">-->
<!--                                </div>-->
<!--                                <div class="ms-3 name">-->
<!--                                    <h5 class="font-bold">John Duck</h5>-->
<!--                                    <h6 class="text-muted">@johnducky</h6>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

                    <!-- VISIT PROFILE BY LOCATION -->
                    <div class="card" id="location">
                        <div class="card-header">
                            <h4>Profile Visit by Location</h4>
                        </div>
                        <br>
                        <div class="card-body">

                            <h6>Europe <span class="float-end">862</span></h6>
                            <div id="chart-europe"></div>

                            <hr>

                            <h6>America <span class="float-end">375</span></h6>
                            <div id="chart-america"></div>

                            <hr>

                            <h6>Asia <span class="float-end">1025</span></h6>
                            <div id="chart-indonesia"></div>
                            <br>
                            <div style="font-style: italic; font-size: 10px; text-align: center;">
                                <p>Current Statistic Trends</p>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer>
            <div class="footer clearfix text-muted">
                <div style="text-align: center !important;">
                    <p>2026 &copy; GlamBook</p>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- SCRIPTS -->
<script src="dist/assets/static/js/components/dark.js"></script>
<script src="dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="dist/assets/compiled/js/app.js"></script>

<script src="dist/assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="dist/assets/static/js/pages/dashboard.js"></script>
</body>
</html>
