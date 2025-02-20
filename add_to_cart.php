<?php
session_start();
include('connect.php');
include('includes/validation.php');

if (!isset($_SESSION['user_id'])) {
    $response['status'] = 'error';
    $response['message'] = 'Please sign in to add items to cart';
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    // Validate and sanitize inputs
    $menu_id = InputValidator::sanitizeInt($_POST['menu_id']);
    if (!is_numeric($menu_id) || $menu_id <= 0) {
        $errors[] = "Invalid menu item.";
    }

    $quantity = InputValidator::sanitizeInt($_POST['quantity']);
    if (!is_numeric($quantity) || $quantity < 1 || $quantity > 10) {
        $errors[] = "Quantity must be between 1 and 10.";
    }

    if (empty($errors)) {
        // Check if item exists in cart
        $sql = "SELECT * FROM cart WHERE menu_id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $menu_id, $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update existing cart item
            $sql = "UPDATE cart SET quantity = quantity + ? WHERE menu_id = ? AND user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $quantity, $menu_id, $_SESSION['user_id']);
        } else {
            // Add new cart item
            $sql = "INSERT INTO cart (menu_id, quantity, user_id) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $menu_id, $quantity, $_SESSION['user_id']);
        }

        if ($stmt->execute() === TRUE) {
            $response['status'] = 'success';
            $response['message'] = 'Item added to cart successfully.';
            echo json_encode($response);
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error: ' . $stmt->error;
            echo json_encode($response);
        }
    } else {
        $response = ['status' => 'error', 'message' => implode("\n", $errors)];
        echo json_encode($response);
        exit();
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
}
$conn->close();
?>