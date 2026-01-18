<?php
$currentPage = 'dashboard';
require_once __DIR__ . "/../../includes/guard.php";
require_once __DIR__ . "/../../../db.php";

/* ===== STATISTICS ===== */

// Registered Users
$qUsers = $connection->query("SELECT COUNT(*) AS total FROM users");
$totalUsers = $qUsers->fetch_assoc()['total'];

// Total Businesses
$qBusinesses = $connection->query("SELECT COUNT(*) AS total FROM businesses");
$totalBusinesses = $qBusinesses->fetch_assoc()['total'];

// Total Reservations
$qReservations = $connection->query("SELECT COUNT(*) AS total FROM reservations");
$totalReservations = $qReservations->fetch_assoc()['total'];

// Total Payments
$qPayments = $connection->query("SELECT COUNT(*) AS total FROM payments");
$totalPayments = $qPayments->fetch_assoc()['total'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <link rel="shortcut icon" href="dist/assets/compiled/svg/favicon.svg" type="image/x-icon">

    <link rel="stylesheet" href="dist/assets/compiled/css/app.css">
    <link rel="stylesheet" href="dist/assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="dist/assets/compiled/css/pinkOnly.css">
</head>

<body>

<div id="app">

    <?php
    include __DIR__ . '/sidebar.php';
    ?>


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
                                    <h6 class="text-muted">Registred users</h6>
                                    <h6 class="font-extrabold mb-0"><?= number_format($totalUsers) ?></h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                    <h6 class="text-muted">Total Businesses</h6>
                                    <h6 class="font-extrabold mb-0">  <?= number_format($totalBusinesses) ?></h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                    <h6 class="text-muted">Total Reservation</h6>
                                    <h6 class="font-extrabold mb-0">  <?= number_format($totalReservations) ?></h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                    <h6 class="text-muted">Total payments</h6>
                                    <h6 class="font-extrabold mb-0"><?= number_format($totalPayments) ?></h6>
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


<script src="dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="dist/assets/compiled/js/app.js"></script>

<script src="dist/assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="dist/assets/static/js/pages/dashboard.js"></script>

</body>
</html>
