<?php
include ('./includes/connect.php');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch all items from the cart
    $sql = "SELECT * FROM cart";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Insert each item into the orders table and update the menu table
        while ($row = $result->fetch_assoc()) {
            $menu_id = $row['menu_id'];
            $quantity = $row['quantity'];

            // Insert into orders table
            $insert_order_sql = "INSERT INTO orders (menu_id, quantity) VALUES ($menu_id, $quantity)";
            if (!$conn->query($insert_order_sql)) {
                $response['status'] = 'error';
                $response['message'] = "Error: " . $insert_order_sql . "<br>" . $conn->error;
                echo json_encode($response);
                exit();
            }

            // Update the menu table to decrease the quantity
            $update_menu_sql = "UPDATE menu SET quantity = quantity - $quantity WHERE id = $menu_id";
            if (!$conn->query($update_menu_sql)) {
                $response['status'] = 'error';
                $response['message'] = "Error: " . $update_menu_sql . "<br>" . $conn->error;
                echo json_encode($response);
                exit();
            }
        }

        // Clear the cart
        $clear_cart_sql = "DELETE FROM cart";
        if ($conn->query($clear_cart_sql) === TRUE) {
            $response['status'] = 'success';
            $response['message'] = "Checkout successful. Your order has been placed.";
        } else {
            $response['status'] = 'error';
            $response['message'] = "Error: " . $clear_cart_sql . "<br>" . $conn->error;
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = "Your cart is empty.";
    }
} else {
    $response['status'] = 'error';
    $response['message'] = "Invalid request method.";
}

$conn->close();
echo json_encode($response);
?>