<?php
session_start();
include('connect.php');

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Please sign in to checkout']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Basic validation
        if (empty($_POST['address']) || strlen($_POST['address']) < 10) {
            throw new Exception("Please enter a valid delivery address (minimum 10 characters)");
        }

        if (empty($_POST['phone']) || !preg_match('/^[0-9+]{11,13}$/', $_POST['phone'])) {
            throw new Exception("Please enter a valid phone number");
        }

        // Start transaction
        $conn->begin_transaction();

        // Get cart items
        $cart_sql = "SELECT c.*, m.price FROM cart c 
                     JOIN menu m ON c.menu_id = m.id 
                     WHERE c.user_id = ?";
        $cart_stmt = $conn->prepare($cart_sql);
        $cart_stmt->bind_param("i", $_SESSION['user_id']);
        $cart_stmt->execute();
        $cart_result = $cart_stmt->get_result();

        if ($cart_result->num_rows == 0) {
            throw new Exception("Your cart is empty");
        }

        // Calculate totals
        $subtotal = 0;
        $items = [];
        while ($item = $cart_result->fetch_assoc()) {
            $subtotal += $item['price'] * $item['quantity'];
            $items[] = $item;
        }

        $shipping_fee = 150;
        $vat = $subtotal * 0.12;
        $total_amount = $subtotal + $shipping_fee + $vat;

        // Create order
        $order_sql = "INSERT INTO orders (user_id, address, phone, notes, total_amount, shipping_fee, vat, status) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
        $order_stmt = $conn->prepare($order_sql);
        $order_stmt->bind_param("isssddd", 
            $_SESSION['user_id'],
            $_POST['address'],
            $_POST['phone'],
            $_POST['notes'],
            $total_amount,
            $shipping_fee,
            $vat
        );

        if (!$order_stmt->execute()) {
            throw new Exception("Failed to create order");
        }

        $order_id = $conn->insert_id;

        // Add order items
        $item_sql = "INSERT INTO order_items (order_id, menu_id, quantity, price) VALUES (?, ?, ?, ?)";
        $item_stmt = $conn->prepare($item_sql);

        foreach ($items as $item) {
            $item_stmt->bind_param("iiid", 
                $order_id,
                $item['menu_id'],
                $item['quantity'],
                $item['price']
            );
            if (!$item_stmt->execute()) {
                throw new Exception("Failed to add order items");
            }
        }

        // Clear cart
        $clear_sql = "DELETE FROM cart WHERE user_id = ?";
        $clear_stmt = $conn->prepare($clear_sql);
        $clear_stmt->bind_param("i", $_SESSION['user_id']);
        
        if (!$clear_stmt->execute()) {
            throw new Exception("Failed to clear cart");
        }

        // Commit transaction
        $conn->commit();

        echo json_encode([
            'status' => 'success',
            'message' => 'Order placed successfully!',
            'redirect' => 'order_history.php'
        ]);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
}
?>