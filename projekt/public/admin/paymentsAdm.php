<?php
require_once __DIR__ . "/../../includes/guard.php";
$currentPage = 'payments';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>

    <link rel="shortcut icon" href="dist/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="dist/assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="dist/assets/compiled/css/table-datatable.css">
    <link rel="stylesheet" href="dist/assets/compiled/css/app.css">
    <link rel="stylesheet" href="dist/assets/compiled/css/pinkOnly.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>
<div id="app">
    <?php include __DIR__ . '/sidebar.php'; ?>

    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h3>Payments</h3>
                        <p class="text-subtitle text-muted">
                            List of all payments (read only)
                        </p>
                    </div>
                </div>
            </div>

            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Payments Table</h5>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped align-middle">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Reservation ID</th>
                                <th>Provider</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                            <tbody id="paymentsBody"></tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script src="dist/assets/compiled/js/app.js"></script>

<script>
    function renderPayments() {
        fetch("paymentsAjax.php", {
            method: "POST",
            body: new URLSearchParams({ action: "fetch_payments" })
        })
            .then(res => res.json())
            .then(response => {
                const tbody = document.getElementById("paymentsBody");
                tbody.innerHTML = "";

                response.data.forEach((p, index) => {
                    tbody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${p.reservation_id}</td>
                        <td>${p.provider}</td>
                        <td>${Number(p.amount).toFixed(2)} €</td>
                        <td>
                            <span class="${
                        p.status === 'paid'
                            ? 'status-active'
                            : p.status === 'pending'
                                ? 'status-warning'
                                : 'status-disabled'
                    }">
                                ${p.status}
                            </span>
                        </td>
                        <td>${p.created_at}</td>
                    </tr>
                `;
                });
            });
    }

    renderPayments();
</script>
</body>
</html>
