<?php
session_start();
include('connect.php');

if (!isset($_SESSION['user_id'])) {
    $response['status'] = 'error';
    $response['message'] = 'Please sign in to add items to cart';
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_id = $_POST['menu_id'];
    $quantity = 1;

    // Check if the item is already in the user's cart
    $sql = "SELECT * FROM cart WHERE menu_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $menu_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update quantity if item is already in the cart
        $sql = "UPDATE cart SET quantity = quantity + 1 WHERE menu_id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $menu_id, $_SESSION['user_id']);
    } else {
        // Insert new item into the cart
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
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
}
$conn->close();
?>