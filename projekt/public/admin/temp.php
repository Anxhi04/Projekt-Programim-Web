<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>

    <link rel="shortcut icon" href="dist/assets/compiled/svg/favicon.svg" type="image/x-icon">

    <link rel="stylesheet" href="dist/assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="dist/assets/compiled/css/table-datatable.css">
    <link rel="stylesheet" href="dist/assets/compiled/css/app.css">
    <link rel="stylesheet" href="dist/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="dist/assets/compiled/css/pinkOnly.css">
</head>

<body>
<script src="dist/assets/static/js/initTheme.js"></script>

<div id="app">

    <!-- ========================= -->
    <!-- ✅ SIDEBAR (I VEÇUAR) -->
    <!-- ========================= -->
    <?php
    // 🔽 NDRYSHIMI KRYESOR
    // Sidebar nuk është më copy–paste këtu
    // por futet nga partial i përbashkët
    include __DIR__ . '/sidebar.php';
    ?>

    <!-- ========================= -->
    <!-- MAIN CONTENT (MBETET NJËLLOJ) -->
    <!-- ========================= -->
    <div id="main">

        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Users</h3>
                        <p class="text-subtitle text-muted">
                            List of all registered users
                        </p>
                    </div>
                </div>
            </div>

            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Users Table</h5>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped" id="table1">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- DATA MBETET NJËLLOJ -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

        <footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-start">
                    <p>2026 &copy; GlamBook</p>
                </div>
            </div>
        </footer>

    </div>
</div>

<!-- ========================= -->
<!-- SCRIPTS (MBETEN NJËLLOJ) -->
<!-- ========================= -->
<script src="dist/assets/static/js/components/dark.js"></script>
<script src="dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="dist/assets/compiled/js/app.js"></script>

<script src="dist/assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="dist/assets/static/js/pages/dashboard.js"></script>

</body>
</html>
