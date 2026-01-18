<?php
require_once __DIR__ . "/guard.php";
require_once __DIR__ . '/../../db.php';

$user_id = $_SESSION['id'] ?? null;

if (!$user_id) {
    header("Location: login.php");
    exit;
}
if (isset($_POST['save'])) {

    $new_firstname = trim ($_POST['firstname'] ?? '');
    $new_lastname  = trim($_POST['lastname'] ?? '');
    $new_email     = trim ($_POST['email'] ?? '');

    // Validimi i te dhenave
    if (empty($new_firstname) || empty($new_lastname) || empty($new_email)) {
        $_SESSION['profile_msg'] = [
            'type' => 'error',
            'text' => 'All fields are required!'
        ];
        header("Location: profile.php");
        exit;
    }
    // Validimi i emrit
    if (!preg_match("/^[a-zA-Z]+$/", $new_firstname)) {
        $_SESSION['profile_msg'] = [
            'type' => 'error',
            'text' => 'First name should contain only letters!'
        ];
        header("Location: profile.php");
        exit;
    }
    // Validimi i mbiemrit
    if (!preg_match("/^[a-zA-Z]+$/", $new_lastname)) {
        $_SESSION['profile_msg'] = [
            'type' => 'error',
            'text' => 'Last name should contain only letters!'
        ];
        header("Location: profile.php");
        exit;
    }
    //Validimi i emailit
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['profile_msg'] = [
            'type' => 'error',
            'text' => 'Please enter a valid email address!'
        ];
        header("Location: profile.php");
        exit;
    }

    $email_check = $connection->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $email_check->bind_param("si", $new_email, $user_id);
    $email_check->execute();
    $result = $email_check->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['profile_msg'] = [
            'type' => 'error',
            'text' => 'This email is already in use!'
        ];
        header("Location: profile.php");
        exit;
    }

    // Lexojme vlerat e vjetra nga databaza
    $query = "SELECT firstname, lastname, email ,profile_photo  FROM users WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    $old_firstname = $row['firstname'];
    $old_lastname  = $row['lastname'];
    $old_email     = $row['email'];
    $old_photo     = $row['profile_photo'];

    if (empty($new_firstname)) $new_firstname = $old_firstname;
    if (empty($new_lastname))  $new_lastname  = $old_lastname;
    if (empty($new_email))     $new_email     = $old_email;

    // Ngarkimi i fotos
    $photo_path = $old_photo;

    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {

        $allowed = ['image/jpeg', 'image/png'];
        $file_type = $_FILES['profile_photo']['type'];
        $file_size = $_FILES['profile_photo']['size'];

        if (!in_array($file_type, $allowed)) {
            $_SESSION['profile_msg'] = [
                'type' => 'error',
                'text' => 'Only JPG and PNG files are allowed!'
            ];
            header("Location: profile.php");
            exit;
        }

        if ($file_size > 2 * 1024 * 1024) {
            $_SESSION['profile_msg'] = [
                'type' => 'error',
                'text' => 'Image must be smaller than 2MB!'
            ];
            header("Location: profile.php");
            exit;
        }

        $folder = __DIR__ . "/uploads/profiles/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $extension = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
        $new_filename = time() . "_" . uniqid() . "." . $extension;

        $relative_path = "uploads/profiles/" . $new_filename;
        $destination   = $folder . $new_filename;

        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $destination)) {
            $photo_path = $relative_path;
        }
        else {
            $_SESSION['profile_msg'] = [
                'type' => 'error',
                'text' => 'Failed to upload image!'
            ];
            header("Location: profile.php");
            exit;
        }
    }

    // Update DB
    $update_query = "UPDATE users SET firstname = ?, lastname = ?, email = ?, profile_photo = ? WHERE id = ?";
    $update_stmt = $connection->prepare($update_query);
    $update_stmt->bind_param("ssssi", $new_firstname, $new_lastname, $new_email, $photo_path, $user_id);

    if ($update_stmt->execute()) {
        $_SESSION['profile_msg'] = [
            'type' => 'success',
            'text' => 'Profile updated successfully!'
        ];
    } else {
        $_SESSION['profile_msg'] = [
            'type' => 'error',
            'text' => 'Failed to update profile!'
        ];
    }

    header('Location: profile.php');
    exit;

}
?>
