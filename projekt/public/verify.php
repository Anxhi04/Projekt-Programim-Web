<?php
echo "<h1>Verify the email</h1>";

//require_once __DIR__ . '/../../db.php';//supozohet te punonte

//require_once __DIR__ . '/functions.php';


$conn = mysqli_connect("localhost", "root", "", "skema");//po e le njehere keshtu
$user_id=$_GET['id'];
$email_token=$_GET['token'];

$query_user = "
    SELECT id, token_date
    FROM users
    WHERE id = ?
    AND email_token = ?
";

$stmt = mysqli_prepare($conn, $query_user);
mysqli_stmt_bind_param($stmt, "is", $user_id, $email_token);
mysqli_stmt_execute($stmt);

$result_user = mysqli_stmt_get_result($stmt);

if (!$result_user || mysqli_num_rows($result_user) === 0) {
    echo "Invalid or expired token";
    exit;
}

$row_user = mysqli_fetch_assoc($result_user);


$valid_datetime = strtotime($row_user['token_date']);
$now = strtotime(date("Y-m-d H:i:s"));


if ($now < $valid_datetime) {
    $query_update = "
                       UPDATE users
                       set
                           email_verified =  'yes',
                           email_verified_at = '".date("Y-m-d H:i:s")."'
                       WHERE id = '".$user_id."'";

    $result_update = mysqli_query($conn, $query_update);
    if (!$result_update) {
        echo "Error: " . $query_update . "<br>" . mysqli_error($conn);
        exit;
    }
    echo "<h1>E-Mail verified successfylly</h1>";
} else{
    echo "<h1>Token is not valid</h1>";
}
