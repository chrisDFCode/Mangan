<?php
session_start();
include('connect.php');

if (!isset($_SESSION['user_id'])) {
    $response = ['status' => 'error', 'message' => 'Please sign in to checkout'];
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING);
    $total_amount = filter_input(INPUT_POST, 'final_total', FILTER_VALIDATE_FLOAT);
    $shipping_fee = filter_input(INPUT_POST, 'shipping', FILTER_VALIDATE_FLOAT);
    $vat = filter_input(INPUT_POST, 'vat', FILTER_VALIDATE_FLOAT);
    $voucher_code = filter_input(INPUT_POST, 'voucher_code', FILTER_SANITIZE_STRING);

    if (!$address || !$phone) {
        echo json_encode(['status' => 'error', 'message' => 'Address and phone are required']);
        exit();
    }

    if (!$total_amount) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid total amount']);
        exit();
    }
    
    // Get cart items
    $cart_sql = "SELECT c.*, m.price FROM cart c 
                 JOIN menu m ON c.menu_id = m.id 
                 WHERE c.user_id = ?";
    $cart_stmt = $conn->prepare($cart_sql);
    $cart_stmt->bind_param("i", $_SESSION['user_id']);
    $cart_stmt->execute();
    $cart_result = $cart_stmt->get_result();

    if ($cart_result->num_rows == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Cart is empty']);
        exit();
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        // First insert the main order
        $order_sql = "INSERT INTO orders (
            user_id, 
            address, 
            phone, 
            notes, 
            total_amount,  /* Changed from total_price */
            shipping_fee, 
            vat, 
            voucher_code
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $order_stmt = $conn->prepare($order_sql);
        $order_stmt->bind_param("isssddds", 
            $_SESSION['user_id'],
            $address,
            $phone,
            $notes,
            $total_amount,
            $shipping_fee,
            $vat,
            $voucher_code
        );
        $order_stmt->execute();
        $order_id = $conn->insert_id;

        // Then insert order items
        $item_sql = "INSERT INTO order_items (order_id, menu_id, quantity, price) VALUES (?, ?, ?, ?)";
        $item_stmt = $conn->prepare($item_sql);
        
        while ($cart_item = $cart_result->fetch_assoc()) {
            $item_stmt->bind_param("iiid", 
                $order_id,
                $cart_item['menu_id'],
                $cart_item['quantity'],
                $cart_item['price']
            );
            $item_stmt->execute();
        }

        // Clear cart after successful order
        $clear_cart = "DELETE FROM cart WHERE user_id = ?";
        $clear_stmt = $conn->prepare($clear_cart);
        $clear_stmt->bind_param("i", $_SESSION['user_id']);
        $clear_stmt->execute();

        $conn->commit();
        $response = [
            'status' => 'success',
            'message' => 'Order placed successfully!',
            'redirect' => 'order_history.php'
        ];
    } catch (Exception $e) {
        $conn->rollback();
        $response = ['status' => 'error', 'message' => 'Failed to place order: ' . $e->getMessage()];
    }

    echo json_encode($response);
    exit();
}
?>