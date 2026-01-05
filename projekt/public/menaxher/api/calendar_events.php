<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/db.php';

header('Content-Type: application/json');
//query nga e cila mnarrim t dhenat per eventet ne kalendar

$sql =  mysqli_query($connection, "
  SELECT 
    r.id,
    s.name AS service_name,
    DATE(r.created_at) AS day,          -- p.sh. 2026-01-05 (ose reservation_date)
    r.start_time,    -- p.sh. 10:00:00
    s.duration_minutes       -- minuta (ose r.duration)
  FROM reservations r
  JOIN services s ON s.id = r.service_id
");
if (!$sql) {
    http_response_code(500);
    echo "<pre>SQL ERROR:\n" . mysqli_error($connection) . "\n\nQUERY:\n$q</pre>";
    exit;
}
$events = [];

while ($row = mysqli_fetch_assoc($sql)) {
    $start = $row["day"] . " " . $row["start_time"];
    $minutes = (int)$row["duration_minutes"];
    $end = date('Y-m-d H:i:s', strtotime($start . " +{$minutes} minutes"));

    $events[] = [
        "id"    => (int)$row["id"],
        "title" => $row["service_name"],
        "start" => $start,
        "end"   => $end,
        "color" => "#8a2be2" // lejlas (opsionale)
    ];
}

//echo json_encode($events);

