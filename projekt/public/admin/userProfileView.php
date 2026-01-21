<?php
require_once __DIR__ . "/../../includes/guard.php";       // kontroll admin
require_once __DIR__ . "/../../../db.php";

if ($_SESSION['role'] !== 'admin') {
    http_response_code(403);
    exit("Access denied");
}

$user_id = $_GET['id'] ?? null;
if (!$user_id) {
    header("Location: users.php");
    exit;
}

// ================= USER DATA =================
$stmt = $connection->prepare(
    "SELECT firstname, lastname, email, profile_photo 
     FROM users WHERE id = ?"
);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    header("Location: users.php");
    exit;
}

// ================= RESERVATIONS =================
$stmt = $connection->prepare("
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
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$appointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile View</title>

    <link rel="stylesheet" href="dist/assets/compiled/css/app.css">
    <link rel="stylesheet" href="dist/assets/compiled/css/pinkOnly.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background:#fbf9f9; }
        .profile-display {
            background:#f6d2e7;
            border-radius:15px;
            padding:30px;
        }
        .profile-img {
            width:130px;
            height:130px;
            border-radius:50%;
            object-fit:cover;
        }
        .profile-card {
            background:#fff;
            border-radius:15px;
            padding:30px;
            border:2px solid #f6daea;
        }
    </style>
</head>

<body>
<div id="app">

    <?php include __DIR__ . "/sidebar.php"; ?>

    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="container py-4">

            <!-- BACK -->
            <a href="usersAdm.php" class="btn btn-secondary mb-4">
                ← Back to users
            </a>

            <!-- PROFILE DISPLAY -->
            <div class="profile-display text-center mb-4">
                <img
                    src="/Projekt-Programim-web/projekt/includes/<?= htmlspecialchars($user['profile_photo'] ?: 'assets/default-user.png') ?>"
                    class="profile-img"
                >
                <h4><?= htmlspecialchars($user['firstname'].' '.$user['lastname']) ?></h4>
                <p class="text-muted"><?= htmlspecialchars($user['email']) ?></p>
            </div>

            <!-- INFO -->
            <div class="profile-card mb-4">
                <h5 class="mb-3">User Information</h5>

                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input class="form-control" value="<?= htmlspecialchars($user['firstname']) ?>" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input class="form-control" value="<?= htmlspecialchars($user['lastname']) ?>" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                </div>
            </div>

            <!-- APPOINTMENTS -->
            <div class="profile-card">
                <h5 class="mb-3">User Appointments</h5>

                <?php if (empty($appointments)): ?>
                    <p class="text-muted">No appointments.</p>
                <?php else: ?>
                    <?php foreach ($appointments as $a): ?>
                        <?php
                        $dt = strtotime($a['date'].' '.$a['start_time']);
                        $status = $dt < time() ? 'Completed' : 'Upcoming';
                        ?>
                        <div class="border-bottom pb-3 mb-3 d-flex justify-content-between">
                            <div>
                                <strong><?= htmlspecialchars($a['service_name']) ?></strong>
                                <div class="text-muted small">
                                    📅 <?= date("d M Y", strtotime($a['date'])) ?>
                                    | ⏰ <?= substr($a['start_time'],0,5) ?>
                                    | 🏥 <?= htmlspecialchars($a['business_name']) ?>
                                </div>
                            </div>
                            <span class="<?= $status === 'Completed' ? 'text-muted' : '' ?>">
                                <?= $status ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
</body>
</html>
