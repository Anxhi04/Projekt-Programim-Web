<?php
require_once __DIR__ . "/../../../db.php";
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["status" => 403, "message" => "Forbidden"]);
    exit;
}

$action = $_POST['action'] ?? '';

function response($status, $message = null, $data = null) {
    echo json_encode([
        "status" => $status,
        "message" => $message,
        "data" => $data
    ]);
    exit;
}

switch ($action) {

    case 'fetch_users':
        $result = $connection->query("
            SELECT id, firstname, lastname, email, role, email_verified, is_active
            FROM users
        ");

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        response(200, null, $users);
        break;

    case 'get_user':
        $id = (int)$_POST['id'];

        $stmt = $connection->prepare("SELECT id, firstname, lastname, email, role, email_verified, is_active FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        response(200, null, $user);
        break;

    case 'add_user':
        $firstname = trim($_POST['firstname']);
        $lastname  = trim($_POST['lastname']);
        $email     = trim($_POST['email']);
        $role      = $_POST['role'];
        $verified  = (int)$_POST['verified'];
        $status    = (int)$_POST['status'];

        $password = password_hash("Temp123!", PASSWORD_DEFAULT);

        $stmt = $connection->prepare("
            INSERT INTO users
            (firstname, lastname, email, password_hash, role, email_verified, is_active, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->bind_param(
            "sssssii",
            $firstname,
            $lastname,
            $email,
            $password,
            $role,
            $verified,
            $status
        );

        $stmt->execute();
        response(200, "User created");
        break;

    case 'update_user':
        $id        = (int)$_POST['id'];
        $firstname = trim($_POST['firstname']);
        $lastname  = trim($_POST['lastname']);
        $email     = trim($_POST['email']);
        $role      = $_POST['role'];
        $verified  = (int)$_POST['verified'];
        $status    = (int)$_POST['status'];

        $stmt = $connection->prepare("
            UPDATE users SET
                firstname = ?,
                lastname = ?,
                email = ?,
                role = ?,
                email_verified = ?,
                is_active = ?,
                updated_at = NOW()
            WHERE id = ?
        ");

        $stmt->bind_param(
            "sssssii",
            $firstname,
            $lastname,
            $email,
            $role,
            $verified,
            $status,
            $id
        );

        $stmt->execute();
        response(200, "User updated");
        break;

    case 'delete_user':
        $id = (int)$_POST['id'];
        $stmt = $connection->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        response(200, "User deleted");
        break;

    case 'toggle_status':
        $id = (int)$_POST['id'];
        $stmt = $connection->prepare("
            UPDATE users
            SET is_active = IF(is_active = 1, 0, 1), updated_at = NOW()
            WHERE id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        response(200, "Status changed");
        break;

    default:
        response(400, "Invalid action");
}
//TODO vadidimi i backendit
//todo rishikimi i struktures se kodit
//todo dergimi i email kur e krijon admini nje user