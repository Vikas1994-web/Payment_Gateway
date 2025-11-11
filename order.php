<?php

require("src/Razorpay.php");

use Razorpay\Api\Api;

$api_key = "YOUR_API_KEY";
$api_secret = "YOUR_SECRET_API_KEY";


// Check if the 'plan' data was sent
if (isset($_POST['plan'])) {
    $plan = $_POST['plan'];
    $amount = 0; // Initialize amount

    // Determine the amount based on the plan
    switch ($plan) {
        case 'silver':
            $amount = 1000;
            break;
        case 'gold':
            $amount = 2000;
            break;
        case 'platinum':
            $amount = 3000;
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid plan specified']);
            exit;
    }

    try {

        $api = new Api($api_key, $api_secret);
        $order = $api->order->create(array(
            'receipt' => 'receipt_' . time(),
            'amount' => $amount * 100,
            'currency' => 'INR',
            'notes' => array(
                'plan' => $plan
            )
        ));
        //print_r($order); die;

        $order_id = $order['id'];
        $order_amount = $order['amount'] / 100;
        $order_plan = $order['notes']['plan'];

        echo json_encode(array(
            "order_id" => $order_id,
            "amount" => $order_amount,
            "plan" => $order_plan
        ));

    } catch (Exception $e) {
        die("Error " . $e->getMessage());
    }
} else {
    // Return an error if no plan was sent
    echo json_encode(['status' => 'error', 'message' => 'No plan data received']);
}
