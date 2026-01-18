<?php

require_once __DIR__ . "/guard.php";
require_once __DIR__ . '/../../db.php';

if (!isset($_POST['reservation_id'])) {
    header("Location: profile.php");
    exit;
}

$reservation_id = $_POST['reservation_id'];
$user_id = $_SESSION['id'];

$update = $connection->prepare("
    UPDATE reservations 
    SET status = 'canceled' 
    WHERE id = ? AND client_user_id = ?
");

$update->bind_param("ii", $reservation_id, $user_id);

if ($update->execute()) {
    $_SESSION['profile_msg'] = [
        'type' => 'success',
        'text' => 'Appointment canceled successfully!'
    ];
} else {
    $_SESSION['profile_msg'] = [
        'type' => 'error',
        'text' => 'Failed to cancel appointment!'
    ];
}

header("Location: profile.php");
exit;

