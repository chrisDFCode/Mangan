<?php
session_start();
include('connect.php');

header('Content-Type: application/json');

$response = array();

if (!isset($_SESSION['user_id'])) {
    $response['status'] = 'error';
    $response['message'] = 'Please sign in to add items to cart';
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_id = $_POST['menu_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    // Validate quantity
    if ($quantity < 1 || $quantity > 10) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid quantity. Please select between 1 and 10.';
        echo json_encode($response);
        exit();
    }

    try {
        // Check if item exists in cart
        $check_sql = "SELECT id, quantity FROM cart WHERE menu_id = ? AND user_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ii", $menu_id, $_SESSION['user_id']);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            // Update existing item
            $cart_item = $result->fetch_assoc();
            $new_quantity = $cart_item['quantity'] + $quantity;
            
            if ($new_quantity > 10) {
                $response['status'] = 'error';
                $response['message'] = 'Cannot add more than 10 items';
                echo json_encode($response);
                exit();
            }

            $update_sql = "UPDATE cart SET quantity = ? WHERE id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("ii", $new_quantity, $cart_item['id']);
        } else {
            // Add new item
            $insert_sql = "INSERT INTO cart (user_id, menu_id, quantity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("iii", $_SESSION['user_id'], $menu_id, $quantity);
        }

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Item added to cart successfully';
        } else {
            throw new Exception("Failed to update cart");
        }

    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
}
$conn->close();
?>