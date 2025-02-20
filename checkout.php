<?php
session_start();
include('connect.php');
include('includes/validation.php');

if (!isset($_SESSION['user_id'])) {
    $response = ['status' => 'error', 'message' => 'Please sign in to checkout'];
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    // Validate and sanitize inputs
    $address = InputValidator::sanitizeString($_POST['address']);
    if (strlen($address) < 10 || strlen($address) > 255) {
        $errors[] = "Address must be between 10 and 255 characters.";
    }

    $phone = $_POST['phone'];
    if (!InputValidator::validatePhone($phone)) {
        $errors[] = "Please enter a valid phone number.";
    }

    $notes = InputValidator::sanitizeString($_POST['notes']);
    if (strlen($notes) > 500) {
        $errors[] = "Notes cannot exceed 500 characters.";
    }

    $total_amount = InputValidator::sanitizeFloat($_POST['final_total']);
    if (!is_numeric($total_amount) || $total_amount <= 0) {
        $errors[] = "Invalid total amount.";
    }

    if (empty($errors)) {
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
    } else {
        echo json_encode(['status' => 'error', 'message' => implode("\n", $errors)]);
        exit();
    }
}
?>