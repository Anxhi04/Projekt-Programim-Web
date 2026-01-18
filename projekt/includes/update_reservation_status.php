<?php
require_once __DIR__ . '/../../db.php';

// përditëso statuset e rezervimeve që kanë kaluar
$update = $connection->prepare("
    UPDATE reservations 
    SET status = 'completed'
    WHERE status IN ('confirmed', 'pending')
      AND date < NOW()
");
$update->execute();

// 2. Merr për front-end vetëm rezervimet që janë 'completed' ose 'pending'
$result = mysqli_query($connection, "
    SELECT id, client_user_id, service_id, date, status 
    FROM reservations
    WHERE status IN ('completed','pending')
    ORDER BY date DESC, id DESC
");

$reservations = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reservations[] = $row;
}
header('Content-Type: application/json');
echo json_encode($reservations);
?>


