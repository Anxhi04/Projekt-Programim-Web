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

// =====================
// VALIDIM BUSINESS
// =====================
function validate_business($name, $status) {
    if (strlen($name) < 3 || strlen($name) > 100) {
        response("error", "Business name must be between 3 and 100 characters.");
    }

    if (!preg_match('/^[a-zA-Z0-9\s\-\_]+$/', $name)) {
        response("error", "Invalid business name format.");
    }

    if (!in_array($status, ['active', 'blocked'])) {
        response("error", "Invalid business status.");
    }
}

switch ($action) {

    // =====================
    // FETCH BUSINESSES
    // =====================
    case 'fetch_businesses':
        $result = mysqli_query($connection, "
            SELECT id, name, description, address, phone, status
            FROM businesses
            ORDER BY id DESC
        ");

        $businesses = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $businesses[] = $row;
        }

        response(200, null, $businesses);
        break;

    // =====================
    // GET BUSINESS
    // =====================
    case 'get_business':
        $id = (int)$_POST['id'];

        $check = mysqli_query($connection, "SELECT id FROM businesses WHERE id = $id");
        if (mysqli_num_rows($check) === 0) {
            response("error", "Business with this ID does not exist.");
        }

        $result = mysqli_query($connection, "
            SELECT id, name, description, address, phone, status
            FROM businesses
            WHERE id = $id
        ");

        $business = mysqli_fetch_assoc($result);
        response(200, null, $business);
        break;

    // =====================
    // UPDATE BUSINESS
    // =====================
    case 'update_business':
        $id          = (int)$_POST['id'];
        $name        = mysqli_real_escape_string($connection, trim($_POST['name']));
        $description = mysqli_real_escape_string($connection, trim($_POST['description'] ?? ''));
        $address     = mysqli_real_escape_string($connection, trim($_POST['address'] ?? ''));
        $phone       = mysqli_real_escape_string($connection, trim($_POST['phone'] ?? ''));
        $status      = $_POST['status'];

        $check = mysqli_query($connection, "SELECT id FROM businesses WHERE id = $id");
        if (mysqli_num_rows($check) === 0) {
            response("error", "Business with this ID does not exist.");
        }

        validate_business($name, $status);

        $check = mysqli_query($connection, "
            SELECT id FROM businesses
            WHERE name = '$name' AND id != $id
        ");
        if (mysqli_num_rows($check) > 0) {
            response("error", "Another business with this name already exists.");
        }

        mysqli_query($connection, "
            UPDATE businesses SET
                name = '$name',
                description = '$description',
                address = '$address',
                phone = '$phone',
                status = '$status',
                updated_at = NOW()
            WHERE id = $id
        ");

        response(200, "Business updated");
        break;

    // =====================
    // DELETE BUSINESS
    // =====================
    case 'delete_business':
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            response("error", "Invalid business ID");
        }

        $id = (int)$_POST['id'];

        $check = mysqli_query($connection, "SELECT id FROM businesses WHERE id = $id");
        if (mysqli_num_rows($check) === 0) {
            response("error", "Business with this ID does not exist.");
        }

        mysqli_query($connection, "DELETE FROM businesses WHERE id = $id");

        response("success", "Business deleted");
        break;

    // =====================
    // TOGGLE STATUS
    // =====================
    case 'toggle_status':
        $id = (int)$_POST['id'];

        $check = mysqli_query($connection, "SELECT id FROM businesses WHERE id = $id");
        if (mysqli_num_rows($check) === 0) {
            response("error", "Business with this ID does not exist.");
        }

        mysqli_query($connection, "
            UPDATE businesses
            SET status = IF(status = 'active', 'blocked', 'active'),
                updated_at = NOW()
            WHERE id = $id
        ");

        response("success", "Status changed");
        break;

    default:
        response(400, "Invalid action");
}
