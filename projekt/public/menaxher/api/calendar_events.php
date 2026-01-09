<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.php';

header('Content-Type: application/json');
//query nga e cila mnarrim t dhenat per eventet ne kalendar
date_default_timezone_set('Europe/Tirane');

//kontrollo lidhjen
if(!isset($connection)|| !$connection){
    http_response_code(500);
    echo json_encode([
        "error" => "No DB connection",
        "details" => "Check db.php (host/user/pass/port/db)"
    ]);
    exit;
}


$sql =  mysqli_query($connection, "
 SELECT
  r.id,
  s.name AS service_name,
  DATE(r.date) AS day,
  r.start_time,
  s.duration_minutes,
  u.firstname AS user_employee
FROM reservations r
JOIN services s ON s.id = r.service_id
JOIN users u ON u.id = s.employee_user_id
WHERE u.role = 'employee'
ORDER BY r.date, r.start_time;

");
if (!$sql) {
    http_response_code(500);
    echo "<pre>SQL ERROR:\n" . mysqli_error($connection) . "\n\nQUERY:\n$q</pre>";
    exit;
}
$events = [];
//
//while($row = mysqli_fetch_assoc($sql)) {
//    echo "<pre>";
//    print_r($row);
//    echo "</pre>\n\n";
//}


while ($row = mysqli_fetch_assoc($sql)) {

    $start = $row["day"] . " " . $row["start_time"];
    $minutes = (int)$row["duration_minutes"];

    $start_timestamp = strtotime($start);
    $end_timestamp = $start_timestamp + ($minutes * 60);
    $employee = $row["user_employee"];



    $events[] = [
        "id" => (int)$row["id"],
        "title" => $row["service_name"] ,
        "start" => date('Y-m-d\TH:i:s', $start_timestamp),
        "end" => date('Y-m-d\TH:i:s', $end_timestamp),
        "color" => "#FF69B4",
        "textColor" => "#ffffff",
        "allDay" => false,
        "employee" => $row["user_employee"],
    ];
}


echo json_encode($events);

