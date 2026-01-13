<?php
// reset_password.php
$id = $_GET['id'] ?? null;
$token = $_GET['token'] ?? null;

if (!$id || !$token) {
    $error = "Invalid reset link.";
} else {
    $error = null;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/Projekt-Programim-Web/projekt/includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Projekt-Programim-Web/projekt/includes/css/custom.css">
    <title>Reset Password</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

<section class="bg-primary py-3 py-md-5 py-xl-8">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-12 col-md-6 col-xl-7">
                <div class="d-flex justify-content-center text-bg-primary">
                    <div class="col-12 col-xl-9">
                        <img class="img-fluid rounded mb-4" loading="lazy" src="./assets/img/bsb-logo-light.svg" width="245" height="80" alt="Logo">
                        <hr class="border-primary-subtle mb-4">
                        <h2 class="h1 mb-4">WELCOME BACK!</h2>
                        <p class="lead mb-5">Set your new password below.</p>
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
                                <div class="mb-4">
                                    <h2 class="h3" style="color: grey">Reset Password</h2>
                                    <h3 class="fs-6 fw-normal text-secondary m-0">
                                        Create a new password for your account.
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php else: ?>
                            <form id="resetForm">
                                <input type="hidden" id="user_id" value="<?php echo htmlspecialchars($id); ?>">
                                <input type="hidden" id="token" value="<?php echo htmlspecialchars($token); ?>">

                                <div class="row gy-3 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="password" id="password" placeholder="New password">
                                            <label for="password" class="form-label">New Password</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm password">
                                            <label for="confirm_password" class="form-label">Confirm Password</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button class="btn btn-primary btn-lg" type="submit">Change password</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-4">
                                    <a href="login.php" class="link-secondary text-decoration-none">Login</a>
                                    <a href="register.php" class="link-secondary text-decoration-none">Register</a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <p class="mt-4 mb-4">Or continue with</p>
                                <div class="d-flex gap-2 gap-sm-3 justify-content-centerX">
                                    <a href="#!" class="btn btn-outline-danger bsb-btn-circle bsb-btn-circle-2xl">G</a>
                                    <a href="#!" class="btn btn-outline-primary bsb-btn-circle bsb-btn-circle-2xl">f</a>
                                    <a href="#!" class="btn btn-outline-dark bsb-btn-circle bsb-btn-circle-2xl"></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("resetForm");
    if (!form) return;

    form.addEventListener("submit", async function(e){
        e.preventDefault();

        const user_id = document.getElementById("user_id").value;
        const token = document.getElementById("token").value;
        const password = document.getElementById("password").value;
        const confirm_password = document.getElementById("confirm_password").value;

        if (password !== confirm_password) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Passwords do not match!',
                confirmButtonText: 'OK'
            });
            return;

        }

        try {
            const res = await fetch("/Projekt-Programim-Web/projekt/public/update_password.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id: user_id, token, password, confirm_password })
            });

            const text = await res.text();
            let data;
            try { data = JSON.parse(text); } catch { data = { error: text }; }

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success 🎉',
                    text: data.message,
                    confirmButtonText: 'Go to Login'
                }).then(() => {
                    window.location.href = "/Projekt-Programim-Web/projekt/public/login.php";
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error || "Something went wrong",
                    confirmButtonText: 'OK'
                });
            }

        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Network Error',
                text: err.message,
                confirmButtonText: 'OK'
            });

        }
    });
});
</script>

</body>
</html>

