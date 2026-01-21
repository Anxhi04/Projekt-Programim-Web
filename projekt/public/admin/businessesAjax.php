<?php
require_once __DIR__ . "/../../../db.php";
session_start();

header("Content-Type: application/json");

// Vetëm admin
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

    if (!in_array($status, ['active', 'blocked'])) {
        response("error", "Invalid business status.");
    }
}

// =====================
// SWITCH ACTION
// =====================
switch ($action) {

    // =====================
    // FETCH BUSINESSES
    // =====================
    case 'fetch_businesses':
        $result = $connection->query("
            SELECT id, name, description, address, phone, status
            FROM businesses
            ORDER BY id DESC
        ");

        $businesses = [];
        while ($row = $result->fetch_assoc()) {
            $businesses[] = $row;
        }

        response(200, null, $businesses);
        break;

    // =====================
    // GET BUSINESS
    // =====================
    case 'get_business':
        $id = (int)$_POST['id'];

        $stmt_check = $connection->prepare("SELECT id FROM businesses WHERE id = ?");
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        $res_check = $stmt_check->get_result();

        if ($res_check->num_rows === 0) {
            response("error", "Business with this ID does not exist.");
        }

        $stmt = $connection->prepare("
            SELECT id, name, description, address, phone, status
            FROM businesses
            WHERE id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $business = $stmt->get_result()->fetch_assoc();

        response(200, null, $business);
        break;

    // =====================
    // ADD BUSINESS
    // =====================
    case 'add_business':
        $name        = trim($_POST['name']);
        $description = trim($_POST['description'] ?? '');
        $address     = trim($_POST['address'] ?? '');
        $phone       = trim($_POST['phone'] ?? '');
        $status      = $_POST['status'];

        validate_business($name, $status);

        // Kontroll duplicate name
        $stmt_check = $connection->prepare("SELECT id FROM businesses WHERE name = ?");
        $stmt_check->bind_param("s", $name);
        $stmt_check->execute();
        if ($stmt_check->get_result()->num_rows > 0) {
            response("error", "A business with this name already exists.");
        }

        $stmt = $connection->prepare("
            INSERT INTO businesses
            (name, description, address, phone, status, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param(
            "sssss",
            $name,
            $description,
            $address,
            $phone,
            $status
        );
        $stmt->execute();

        response(200, "Business created");
        break;

    // =====================
    // UPDATE BUSINESS
    // =====================
    case 'update_business':
        $id          = (int)$_POST['id'];
        $name        = trim($_POST['name']);
        $description = trim($_POST['description'] ?? '');
        $address     = trim($_POST['address'] ?? '');
        $phone       = trim($_POST['phone'] ?? '');
        $status      = $_POST['status'];

        $stmt_check = $connection->prepare("SELECT id FROM businesses WHERE id = ?");
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        if ($stmt_check->get_result()->num_rows === 0) {
            response("error", "Business with this ID does not exist.");
        }

        validate_business($name, $status);

        // Kontroll duplicate name (përveç vetes)
        $stmt_check = $connection->prepare("SELECT id FROM businesses WHERE name = ? AND id != ?");
        $stmt_check->bind_param("si", $name, $id);
        $stmt_check->execute();
        if ($stmt_check->get_result()->num_rows > 0) {
            response("error", "Another business with this name already exists.");
        }

        $stmt = $connection->prepare("
            UPDATE businesses SET
                name = ?,
                description = ?,
                address = ?,
                phone = ?,
                status = ?,
                updated_at = NOW()
            WHERE id = ?
        ");
        $stmt->bind_param(
            "sssssi",
            $name,
            $description,
            $address,
            $phone,
            $status,
            $id
        );
        $stmt->execute();

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

        $stmt_check = $connection->prepare("SELECT id FROM businesses WHERE id = ?");
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        if ($stmt_check->get_result()->num_rows === 0) {
            response("error", "Business with this ID does not exist.");
        }

        $stmt = $connection->prepare("DELETE FROM businesses WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        response("success", "Business deleted");
        break;

    // =====================
    // TOGGLE STATUS
    // =====================
    case 'toggle_status':
        $id = (int)$_POST['id'];

        $stmt_check = $connection->prepare("SELECT id FROM businesses WHERE id = ?");
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        if ($stmt_check->get_result()->num_rows === 0) {
            response("error", "Business with this ID does not exist.");
        }

        $stmt = $connection->prepare("
            UPDATE businesses
            SET status = IF(status = 'active', 'blocked', 'active'),
                updated_at = NOW()
            WHERE id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        response(200, "Status changed");
        break;

    default:
        response(400, "Invalid action");
}
