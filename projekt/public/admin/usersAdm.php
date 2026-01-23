<?php
require_once __DIR__ . "/../../includes/guard.php";
$currentPage = 'users';
?>

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
                        <h3>Users</h3>
                        <p class="text-subtitle text-muted">List of all registered users</p>
                    </div>
                </div>
            </div>

            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Users Table</h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3 text-end">
                            <button class="btn" onclick="openAddModal()">+ Add User</button>
                        </div>

                        <table class="table table-striped align-middle">
                            <thead>
                            <tr>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Email</th>
                                <th>Verified</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th style="width:160px">Actions</th>
                            </tr>
                            </thead>
                            <tbody id="usersBody"></tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script src="dist/assets/compiled/js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="userId">

                <div class="mb-3">
                    <label>Firstname</label>
                    <input type="text" id="firstname" class="form-control">
                    <small id="firstname_message" class="text-danger"></small>
                </div>

                <div class="mb-3">
                    <label>Lastname</label>
                    <input type="text" id="lastname" class="form-control">
                    <small id="lastname_message" class="text-danger"></small>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" id="email" class="form-control">
                    <small id="email_message" class="text-danger"></small>
                </div>

                <div class="mb-3">
                    <label>Role</label>
                    <select id="role" class="form-select">
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                        <option value="user">User</option>
                    </select>

                </div>

                <div class="mb-3">
                    <label>Email Verified</label>
                    <select id="verified" class="form-select">
                        <option>Yes</option>
                        <option>No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select id="status" class="form-select">
                        <option value="Active">Active</option>
                        <option value="Disabled">Disabled</option>
                    </select>
                </div>


            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn pink" onclick="saveUser()">Save</button>
            </div>

        </div>
    </div>
</div>

<script>
    const modal = new bootstrap.Modal(document.getElementById('userModal'));

    function renderUsers() {
        fetch("usersAjax.php", {
            method: "POST",
            body: new URLSearchParams({ action: "fetch_users" })
        })
            .then(res => res.json())
            .then(response => {
                const tbody = document.getElementById("usersBody");
                tbody.innerHTML = "";

                response.data.forEach(u => {
                    tbody.innerHTML += `
                <tr>
                    <td>${u.firstname}</td>
                    <td>${u.lastname}</td>
                    <td>${u.email}</td>
                    <td>${u.email_verified == 1 ? 'Yes' : 'No'}</td>
                    <td>${u.role}</td>
                    <td>
                        <span class="${u.is_active == 1 ? 'status-active' : 'status-disabled'}">
                            ${u.is_active == 1 ? 'Active' : 'Disabled'}
                        </span>
                    </td>
                    <td>
                        <i class="bi bi-eye" onclick="viewProfile(${u.id})"></i>
                        <i class="bi bi-pencil-square" onclick="editUser(${u.id})"></i>
                        <i class="bi ${u.is_active == 1 ? 'bi-ban' : 'bi-check-circle'}" onclick="toggleStatus(${u.id})"></i>
                        <i class="bi bi-trash" onclick="deleteUser(${u.id})"></i>
                    </td>
                </tr>
            `;
                });
            });
    }

    function openAddModal() {
        document.getElementById('modalTitle').innerText = 'Add User';
        document.getElementById('userId').value = '';
        document.getElementById('firstname').value = '';
        document.getElementById('lastname').value = '';
        document.getElementById('email').value = '';
        document.getElementById('role').value = 'admin';
        document.getElementById('verified').value = 'No';
        document.getElementById('status').value = 'Active';
        modal.show();
    }

    function viewProfile(id) {
        window.location.href = "userProfileView.php?id=" + id;
    }



    function editUser(id) {
        fetch("usersAjax.php", {
            method: "POST",
            body: new URLSearchParams({ action: "get_user", id: id })
        })
            .then(res => res.json())
            .then(response => {
                const u = response.data;
                document.getElementById('modalTitle').innerText = 'Edit User';
                document.getElementById('userId').value = u.id;
                document.getElementById('firstname').value = u.firstname;
                document.getElementById('lastname').value = u.lastname;
                document.getElementById('email').value = u.email;
                document.getElementById('role').value = u.role;
                document.getElementById('verified').value = u.email_verified == 1 ? 'Yes' : 'No';
                document.getElementById('status').value = u.is_active == 1 ? 'Active' : 'Disabled';
                modal.show();
            });
    }

    function saveUser() {

        var error = 0;

        var firstnameVal = firstname.value.trim();
        var lastnameVal  = lastname.value.trim();
        var emailVal     = email.value.trim();

        var alpha_regex = /^[a-zA-Z]{3,40}$/;
        var email_regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        // ===================== FRONTEND VALIDATION =====================

        if (!alpha_regex.test(firstnameVal)) {
            firstname.classList.add("border-danger");
            document.getElementById("firstname_message").innerText =
                "Firstname must be alphabetic and at least 3 letters.";
            error++;
        } else {
            firstname.classList.remove("border-danger");
            document.getElementById("firstname_message").innerText = "";
        }

        if (!alpha_regex.test(lastnameVal)) {
            lastname.classList.add("border-danger");
            document.getElementById("lastname_message").innerText =
                "Lastname must be alphabetic and at least 3 letters.";
            error++;
        } else {
            lastname.classList.remove("border-danger");
            document.getElementById("lastname_message").innerText = "";
        }

        if (!email_regex.test(emailVal)) {
            email.classList.add("border-danger");
            document.getElementById("email_message").innerText =
                "E-mail format is not allowed.";
            error++;
        } else {
            email.classList.remove("border-danger");
            document.getElementById("email_message").innerText = "";
        }

        if (error > 0) return;

        // ===================== AJAX SAVE  =====================

        const data = new URLSearchParams({
            action: userId.value ? "update_user" : "add_user",
            id: userId.value,
            firstname: firstnameVal,
            lastname: lastnameVal,
            email: emailVal,
            role: role.value,
            verified: verified.value === "Yes" ? 1 : 0,
            status: status.value === "Active" ? 1 : 0
        });

        fetch("usersAjax.php", { method: "POST", body: data })
            .then(res => res.json())
            .then(() => {
                modal.hide();
                renderUsers();
            });
    }

    function deleteUser(id) {

        Swal.fire({
            title: "Are you sure?",
            text: "This user will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e74c3c",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete",
            cancelButtonText: "Cancel"
        }).then((result) => {

            if (result.isConfirmed) {

                fetch("usersAjax.php", {
                    method: "POST",
                    body: new URLSearchParams({
                        action: "delete_user",
                        id: id
                    })
                })
                    .then(res => res.json())
                    .then(response => {

                        if (response.status === "success") {

                            Swal.fire({
                                title: "Deleted!",
                                text: response.message,
                                icon: "success",
                                confirmButtonColor: "#e91e63"
                            });


                            renderUsers();

                        } else {

                            Swal.fire({
                                title: "Error",
                                text: response.message,
                                icon: "error",
                                confirmButtonColor: "#e74c3c"
                            });

                        }

                    })
                    .catch(() => {
                        Swal.fire({
                            title: "Error",
                            text: "Unexpected error occurred",
                            icon: "error",
                            confirmButtonColor: "#e74c3c"
                        });
                    });
            }
        });
    }



    function toggleStatus(id) {
        fetch("usersAjax.php", {
            method: "POST",
            body: new URLSearchParams({ action: "toggle_status", id })
        }).then(() => renderUsers());
    }

    renderUsers();


</script>
</body>
</html>