<?php
include ('connect.php');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cart_id']) && isset($_POST['action'])) {
        $cart_id = $_POST['cart_id'];
        $action = $_POST['action'];

        if ($action == 'increase') {
            $sql = "UPDATE cart SET quantity = quantity + 1 WHERE id = ?";
        } elseif ($action == 'decrease') {
            $sql = "UPDATE cart SET quantity = quantity - 1 WHERE id = ? AND quantity > 1";
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invalid action.';
            echo json_encode($response);
            exit();
        }

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cart_id);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Cart updated successfully.';
        } else {
            $response['status'] = 'error';
            $response['message'] = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Missing cart_id or action.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

$conn->close();
echo json_encode($response);
?>