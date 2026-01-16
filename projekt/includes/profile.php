<?php
require_once __DIR__ . "/guard.php";
require_once __DIR__ . "/partials/header.php";
require_once __DIR__ . '/../../db.php';

require_once __DIR__ . "/guard.php";
require_once __DIR__ . "/partials/header.php";
require_once __DIR__ . '/../../db.php';

$user_id = $_SESSION['id'] ?? null;

$query = "SELECT firstname, lastname, email, profile_photo FROM users WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$query = "
SELECT 
    r.date,
    r.start_time,
    s.name AS service_name,
    b.name AS business_name
FROM reservations r
INNER JOIN services s ON r.service_id = s.id
INNER JOIN businesses b ON s.business_id = b.id
WHERE r.client_user_id = ?
ORDER BY r.date DESC, r.start_time DESC
";

$stmt = $connection->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$appointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Bootstrap -->

    <style>
        body {
            background: #fbf9f9;
            font-family: 'Segoe UI', sans-serif;
        }
        .profile-display {
            background: #f6d2e7;
            border-radius: 15px;
            padding: 30px;
            box-shadow: inset -30px -20px 60px 15px rgb(246, 242, 244);


        }
        .profile-img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 4px solid #f4eaed;
            object-fit: cover;
        }
        .text{
            color: #d31262;
        }
        .profile-edit {
            background: #fbfbfb;
            border-radius: 15px;
            padding: 30px;
            box-shadow: inset 0 0 0 0 rgb(251, 239, 245);
            border: 2px solid #f6daea;


        }
        .btn-pink {
            background-color: #ed4582;
            border: none;
        }
        .btn-pink:hover {
            background-color: #ff6d9c;
        }
        .btn-gray{
            background-color: #c8ccd3;
        }
        .btn-gray:hover{
            background-color: #e4e5ea;
        }
        .form-control:focus {
            border-color: #ed0c5d;
            box-shadow: 0 0 0 0.2rem rgba(255, 138, 180, 0.4);
        }
        .title-text {
            color: #7a0744;
            font-weight: 600;
        }
        .form-label{
            color: #d31262;
        }
        .appointments-card {
            background: #fbfbfb;
            border-radius: 15px;
            padding: 25px;
            border: 2px solid #f6daea;
        }

    </style>
</head>

<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <!-- Profile Display Card -->
        <div class="col-md-9 mb-5">
            <div class="profile-card profile-display text-center">
                <img src="<?= $user['profile_photo'] ?: 'assets/default-user.png' ?>" class="profile-img" >
                <h4 class="title-text mb-0"><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></h4>
                <p class="text">✨</p>
            </div>
        </div>

        <!-- Edit Form Card -->
        <div class="col-md-9">
            <div class="profile-card profile-edit">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="title-text mb-0">Personal Information</h5>
                    <button type="button" class="btn btn-pink text-white fw-semibold" id="editBtn">
                        Edit Profile
                    </button>
                </div>

                <form id="profileForm" method="POST" action="profileBackend.php" enctype="multipart/form-data">

                <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control"  name="firstname" id="firstname" value="<?= htmlspecialchars($user['firstname']) ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" value="<?= htmlspecialchars($user['lastname']) ?>"disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" id="email"  value="<?= htmlspecialchars($user['email']) ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Profile Photo</label>
                        <input type="file" class="form-control" name="profile_photo" id="profile_photo"  disabled>
                    </div>

                    <div class="d-flex  gap-3  d-none" id="actionButtons">
                        <button type="submit" name="save" class="btn btn-pink text-white w-100 fw-semibold" id="saveBtn">
                            Save Changes
                        </button>
                        <button type="button" class="btn btn-gray text-black w-100 fw-semibold" id="cancelBtn">
                            Cancel
                        </button>
                    </div>
                </form>

            </div>
        </div>
        <!-- Appointments Card -->
        <div class="col-md-9 mt-5">
            <div class="profile-card appointments-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="title-text mb-0">My Appointments</h5>
                </div>

                <div class="mt-3">
                        <?php if (empty($appointments)): ?>
                            <p class="text-muted">You have no appointments yet.</p>
                        <?php else: ?>

                            <?php foreach ($appointments as $a): ?>
                                <?php
                                // Build datetime
                                $appointmentDateTime = strtotime(date('Y-m-d',strtotime($a['date'])). ' ' . $a['start_time']);
                                $now = time();

                                // Determine status
                                $status = ($appointmentDateTime < $now) ? "Completed" : "Upcoming";
                                ?>
                                <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                                    <div>
                                        <h6 class="mb-1" style="color:#7a0744;"><?= htmlspecialchars($a['service_name']) ?></h6>

                                        <div class="d-flex align-items-center gap-2 text-muted small">
                                            <span>📅 <?= date("d M Y", strtotime($a['date'])) ?></span>
                                            <span>|</span>
                                            <span>⏰ <?= substr($a['start_time'], 0, 5) ?></span>
                                            <span>|</span>
                                            <span>🏥 <?= htmlspecialchars($a['business_name']) ?></span>
                                        </div>
                                    </div>
                                    <div class="text-end fw-semibold <?= $status === 'Completed' ? 'text-muted' : '' ?>">
                                        <?= $status ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        <?php endif; ?>
                    </div>

            </div>
        </div>

    </div>
</div>


        <script>
            const editBtn = document.getElementById("editBtn");
            const actionButtons = document.getElementById("actionButtons");
            const inputs = document.querySelectorAll("#profileForm input");

            editBtn.addEventListener("click", () => {
                inputs.forEach(input => input.disabled = false);
                actionButtons.classList.remove("d-none");
                editBtn.classList.add("d-none");
            });

            document.getElementById("cancelBtn").addEventListener("click", () => {
                inputs.forEach(input => input.disabled = true);
                actionButtons.classList.add("d-none");
                editBtn.classList.remove("d-none");
            });
        </script>
<script>
    const form = document.getElementById("profileForm");
    const firstname = document.getElementById("firstname");
    const lastname = document.getElementById("lastname");
    const email = document.getElementById("email");
    const photo = document.getElementById("profile_photo");

    form.addEventListener("submit", function(e) {

        // Validimi i emrit - vetëm shkronja
        const nameRegex = /^[a-zA-Z]+$/;
        if (!nameRegex.test(firstname.value.trim())) {
            e.preventDefault();
            Swal.fire("Invalid Name", "First name should contain only letters.", "error");
            return;
        }

        // Validimi i mbiemrit - vetëm shkronja
        if (!nameRegex.test(lastname.value.trim())) {
            e.preventDefault();
            Swal.fire("Invalid Last Name", "Last name should contain only letters.", "error");
            return;
        }

        // Validimi i email-it
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value.trim())) {
            e.preventDefault();
            Swal.fire("Invalid Email", "Please enter a valid email address.", "error");
            return;
        }

        // Validimi i fotos
        if (photo.files.length > 0) {
            const allowed = ["image/jpeg", "image/png"];
            const file = photo.files[0];

            if (!allowed.includes(file.type)) {
                e.preventDefault();
                Swal.fire("Invalid File", "Only JPG or PNG images are allowed.", "error");
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                e.preventDefault();
                Swal.fire("File Too Large", "Image must be smaller than 2MB.", "error");
                return;
            }
        }
    });
</script>

</body>
</html>
<?php
if (isset($_SESSION['profile_msg'])) {
    $msg = $_SESSION['profile_msg'];
    echo "
    <script>
        Swal.fire({
            icon: '{$msg['type']}',
            title: '{$msg['text']}',
            confirmButtonColor: '#d33',
        });
    </script>
    ";
    unset($_SESSION['profile_msg']);
}
?>

