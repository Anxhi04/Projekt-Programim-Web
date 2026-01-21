<?php
error_reporting(0);
session_start();

require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/stripe_inicialization.php';

if ($_POST['action'] === "create_customer_and_pay") {

    $payment_method  = mysqli_real_escape_string($connection, $_POST['payment_method']);
    $cardholder_name = trim(mysqli_real_escape_string($connection, $_POST['cardholder_name']));
    $service_id      = (int) $_POST['service_id'];

    $user_id    = $_SESSION['id'];
    $user_email = $_SESSION['email'];
    $firstname  = $_SESSION['firstname'];

    $q = mysqli_query($connection, "
        SELECT price 
        FROM services 
        WHERE id = '{$service_id}' AND is_active = 1
        LIMIT 1
    ");

    if (mysqli_num_rows($q) === 0) {
        echo json_encode(["status" => 404, "message" => "Service not found"]);
        exit;
    }

    $service = mysqli_fetch_assoc($q);
    $amount  = (float) $service['price'];

    try {

        // ================= STRIPE CUSTOMER =================
        $customer = \Stripe\Customer::create([
            'payment_method' => $payment_method,
            'email' => $user_email,
            'name' => $cardholder_name,
            'metadata' => [
                'user_id' => $user_id,
                'service_id' => $service_id
            ],
        ]);

        // ================= PAYMENT INTENT =================
        $intent = \Stripe\PaymentIntent::create([
            'amount' => intval($amount * 100),
            'currency' => 'eur',
            'customer' => $customer->id,
            'payment_method' => $payment_method,
            'payment_method_types' => ['card'],
            'metadata' => [
                'user_id' => $user_id,
                'service_id' => $service_id
            ]
        ]);


        $log_response = mysqli_real_escape_string(
            $connection,
            json_encode([
                'id'       => $intent->id,
                'status'   => $intent->status,
                'amount'   => $intent->amount,
                'currency' => $intent->currency,
                'customer' => $intent->customer
            ])
        );

        // ================= LOG STRIPE =================
        mysqli_query($connection, "
            INSERT INTO third_party_logs
            SET
                provider = 'stripe',
                request_payload = 'CREATE PAYMENT INTENT',
                response_payload = '{$log_response}',
                status_code = 200,
                created_at = NOW()
        ");

        echo json_encode([
            "status" => 200,
            "client_secret" => $intent->client_secret
        ]);
        exit;

    } catch (Exception $e) {
        echo json_encode([
            "status" => 500,
            "message" => $e->getMessage()
        ]);
        exit;
    }
}

elseif ($_POST['action'] === 'save_payment') {

    if (!isset($_SESSION['id'])) {
        echo json_encode(["status" => 401, "message" => "Session missing"]);
        exit;
    }

    $payment_intent_id = mysqli_real_escape_string($connection, $_POST['payment_intent_id']);
    $service_id        = (int) $_POST['service_id'];
    $user_id           = $_SESSION['id'];

    $q = mysqli_query($connection, "
        SELECT price 
        FROM services 
        WHERE id = '{$service_id}'
        LIMIT 1
    ");

    $service = mysqli_fetch_assoc($q);
    $amount  = (float) $service['price'];

    // ================= PAYMENTS INSERT =================
    mysqli_query($connection, "
        INSERT INTO payments
        SET
            reservation_id = '{$service_id}',
            provider = 'stripe',
            amount = '{$amount}',
            currency = 'EUR',
            status = 'paid',
            provider_transaction_id = '{$payment_intent_id}',
            created_at = NOW()
    ");

    $payment_id = mysqli_insert_id($connection);

    // ================= FINAL LOG =================
    $final_log = mysqli_real_escape_string(
        $connection,
        json_encode([
            'payment_intent_id' => $payment_intent_id,
            'status' => 'succeeded'
        ])
    );

    mysqli_query($connection, "
        INSERT INTO third_party_logs
        SET
            provider = 'stripe',
            payment_id = '{$payment_id}',
            request_payload = 'PAYMENT CONFIRMATION',
            response_payload = '{$final_log}',
            status_code = 200,
            created_at = NOW()
    ");

    echo json_encode(["status" => 200]);
    exit;
}
