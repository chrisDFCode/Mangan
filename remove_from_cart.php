<?php
include ('./includes/connect.php');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = $_POST['cart_id'];

    $sql = "DELETE FROM cart WHERE id = $cart_id";

    if ($conn->query($sql) === TRUE) {
        $response['status'] = 'success';
        $response['message'] = 'Item removed from cart successfully.';
    } else {
        $response['status'] = 'error';
        $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

$conn->close();
echo json_encode($response);
?>