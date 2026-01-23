<?php
require_once __DIR__ . "/../../../db.php";
session_start();

header("Content-Type: application/json");

// Vetëm admin mund të përdorë këto endpoint-e
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

// =====================
// FUNKSION VALIDIMI
// =====================
function validate_user($firstname, $lastname, $email, $role, $verified, $status) {
    $alpha_regex = "/^[a-zA-Z]{3,40}$/";
    $email_regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $allowed_roles = ['admin', 'manager', 'user'];

    if (!preg_match($alpha_regex, $firstname)) {
        response("error", "Firstname must be alphabetic and 3–40 letters.");
    }

    if (!preg_match($alpha_regex, $lastname)) {
        response("error", "Lastname must be alphabetic and 3–40 letters.");
    }

    if (!preg_match($email_regex, $email)) {
        response("error", "Invalid email format.");
    }

    if (!in_array($role, $allowed_roles)) {
        response("error", "Invalid role.");
    }

    if (!in_array($verified, [0,1])) {
        response("error", "Invalid verified value.");
    }

    if (!in_array($status, [0,1])) {
        response("error", "Invalid status value.");
    }
}

// =====================
// SWITCH ACTION
// =====================
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
        // Kontroll ID ekzistence
        $stmt_check = $connection->prepare("SELECT id FROM users WHERE id = ?");
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        $res_check = $stmt_check->get_result();
        if ($res_check->num_rows === 0) {
            response("error", "User with this ID does not exist.");
        }

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

        // VALIDIM
        validate_user($firstname, $lastname, $email, $role, $verified, $status);

        // Kontroll duplicate email
        $stmt_check = $connection->prepare("SELECT id FROM users WHERE email = ?");
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $res_check = $stmt_check->get_result();
        if ($res_check->num_rows > 0) {
            response("error", "A user with this email already exists.");
        }

//        $password = password_hash("Temp123!", PASSWORD_DEFAULT);
        $password = null;


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

        // Kontroll ID ekzistence
        $stmt_check = $connection->prepare("SELECT id FROM users WHERE id = ?");
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        $res_check = $stmt_check->get_result();
        if ($res_check->num_rows === 0) {
            response("error", "User with this ID does not exist.");
        }

        // VALIDIM
        validate_user($firstname, $lastname, $email, $role, $verified, $status);

        // Kontroll duplicate email (perveç vetes)
        $stmt_check = $connection->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt_check->bind_param("si", $email, $id);
        $stmt_check->execute();
        $res_check = $stmt_check->get_result();
        if ($res_check->num_rows > 0) {
            response("error", "Another user with this email already exists.");
        }

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

        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            response("error", "Invalid user ID");
        }
        $id = (int) $_POST['id'];


        $stmt_check = $connection->prepare("SELECT id FROM users WHERE id = ?");
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        $res_check = $stmt_check->get_result();

        if ($res_check->num_rows === 0) {
            response("error", "User with this ID does not exist.");
        }


        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id) {
            response("error", "You cannot delete yourself.");
        }


        $stmt_delete = $connection->prepare("DELETE FROM users WHERE id = ?");
        $stmt_delete->bind_param("i", $id);

        if ($stmt_delete->execute()) {
            response("success", "User deleted successfully");
        } else {
            response("error", "Failed to delete user");
        }
        break;


    case 'toggle_status':
        $id = (int)$_POST['id'];

        // Kontroll ID ekzistence
        $stmt_check = $connection->prepare("SELECT id FROM users WHERE id = ?");
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        $res_check = $stmt_check->get_result();
        if ($res_check->num_rows === 0) {
            response("error", "User with this ID does not exist.");
        }

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
