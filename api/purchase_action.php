<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read input (since we will send JSON from frontend)
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        echo json_encode(['success' => false, 'error' => 'Invalid data']);
        exit;
    }
    
    $product_id = isset($input['product_id']) ? $input['product_id'] : '';
    $product_name = isset($input['product_name']) ? $input['product_name'] : '';
    $purchased_items = isset($input['items']) ? $input['items'] : []; // Array of {name, price}
    $customer_name = isset($input['name']) ? $input['name'] : '';
    $customer_email = isset($input['email']) ? $input['email'] : '';
    $customer_phone = isset($input['phone']) ? $input['phone'] : '';
    $customer_notes = isset($input['notes']) ? $input['notes'] : '';
    
    if (empty($purchased_items) || empty($customer_name) || empty($customer_email) || empty($customer_phone)) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        exit;
    }
    
    $id = uniqid('req_');
    $timestamp = date('Y-m-d H:i:s');
    
    $customer = [
        'name' => $customer_name,
        'email' => $customer_email,
        'phone' => $customer_phone,
        'notes' => $customer_notes
    ];
    
    try {
        dbExecute(
            "INSERT INTO purchases (id, timestamp, product_id, product_name, items, customer, status) 
             VALUES (:id, :timestamp, :product_id, :product_name, :items, :customer, 'Pending')",
            [
                ':id'           => $id,
                ':timestamp'    => $timestamp,
                ':product_id'   => $product_id,
                ':product_name' => $product_name,
                ':items'        => json_encode($purchased_items),
                ':customer'     => json_encode($customer),
            ]
        );
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Failed to save data: ' . $e->getMessage()]);
    }
    exit;
}

echo json_encode(['success' => false, 'error' => 'Invalid request method']);
