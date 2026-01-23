<?php
require_once __DIR__ . "/../../includes/guard.php";
$currentPage = 'businesses';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Businesses</title>

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
                        <h3>Businesses</h3>
                        <p class="text-subtitle text-muted">List of all registered businesses</p>
                    </div>
                </div>
            </div>

            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Businesses Table</h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3 text-end">
                            <button class="btn" onclick="openAddModal()">+ Add Business</button>
                        </div>

                        <table class="table table-striped align-middle">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th style="width:160px">Actions</th>
                            </tr>
                            </thead>
                            <tbody id="businessesBody"></tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script src="dist/assets/compiled/js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- MODAL -->
<div class="modal fade" id="businessModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Business</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="businessId">

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" id="name" class="form-control">
                    <small id="name_message" class="text-danger"></small>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea id="description" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Address</label>
                    <input type="text" id="address" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Phone</label>
                    <input type="text" id="phone" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select id="status" class="form-select">
                        <option value="active">Active</option>
                        <option value="blocked">Blocked</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn pink" onclick="saveBusiness()">Save</button>
            </div>

        </div>
    </div>
</div>

<script>

    const nameInput = document.getElementById("name");
    const descriptionInput = document.getElementById("description");
    const addressInput = document.getElementById("address");
    const phoneInput = document.getElementById("phone");
    const statusInput = document.getElementById("status");
    const businessIdInput = document.getElementById("businessId");
    const modalTitle = document.getElementById("modalTitle");
    const name_message = document.getElementById("name_message");

    const modal = new bootstrap.Modal(document.getElementById('businessModal'));

    function renderBusinesses() {
        fetch("businessesAjax.php", {
            method: "POST",
            body: new URLSearchParams({ action: "fetch_businesses" })
        })
            .then(res => res.json())
            .then(response => {
                const tbody = document.getElementById("businessesBody");
                tbody.innerHTML = "";

                response.data.forEach(b => {
                    tbody.innerHTML += `
                <tr>
                    <td>${b.name}</td>
                    <td>${b.description ?? ''}</td>
                    <td>${b.address ?? ''}</td>
                    <td>${b.phone ?? ''}</td>
                    <td>
                        <span class="${b.status === 'active' ? 'status-active' : 'status-disabled'}">
                            ${b.status === 'active' ? 'Active' : 'Blocked'}
                        </span>
                    </td>
                    <td>
                        <i class="bi bi-pencil-square" onclick="editBusiness(${b.id})"></i>
                        <i class="bi ${b.status === 'active' ? 'bi-ban' : 'bi-check-circle'}" onclick="toggleStatus(${b.id})"></i>
                        <i class="bi bi-trash" onclick="deleteBusiness(${b.id})"></i>
                    </td>
                </tr>`;
                });
            });
    }

    function openAddModal() {
        modalTitle.innerText = "Add Business";
        businessIdInput.value = "";
        nameInput.value = "";
        descriptionInput.value = "";
        addressInput.value = "";
        phoneInput.value = "";
        statusInput.value = "active";
        modal.show();
    }

    function editBusiness(id) {
        fetch("businessesAjax.php", {
            method: "POST",
            body: new URLSearchParams({ action: "get_business", id })
        })
            .then(res => res.json())
            .then(res => {
                const b = res.data;
                modalTitle.innerText = "Edit Business";
                businessIdInput.value = b.id;
                nameInput.value = b.name;
                descriptionInput.value = b.description;
                addressInput.value = b.address;
                phoneInput.value = b.phone;
                statusInput.value = b.status;
                modal.show();
            });
    }

    function saveBusiness() {
        if (nameInput.value.trim().length < 3) {
            nameInput.classList.add("border-danger");
            name_message.innerText = "Name must be at least 3 characters";
            return;
        } else {
            nameInput.classList.remove("border-danger");
            name_message.innerText = "";
        }

        fetch("businessesAjax.php", {
            method: "POST",
            body: new URLSearchParams({
                action: businessIdInput.value ? "update_business" : "add_business",
                id: businessIdInput.value,
                name: nameInput.value,
                description: descriptionInput.value,
                address: addressInput.value,
                phone: phoneInput.value,
                status: statusInput.value
            })
        })
            .then(() => {
                modal.hide();
                renderBusinesses();
            });
    }

    function deleteBusiness(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "Business will be deleted permanently!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e74c3c"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("businessesAjax.php", {
                    method: "POST",
                    body: new URLSearchParams({ action: "delete_business", id })
                }).then(() => renderBusinesses());
            }
        });
    }

    function toggleStatus(id) {
        fetch("businessesAjax.php", {
            method: "POST",
            body: new URLSearchParams({ action: "toggle_status", id })
        }).then(() => renderBusinesses());
    }

    renderBusinesses();
</script>
</body>
</html>
