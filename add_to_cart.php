<?php
include ('./includes/connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_id = $_POST['menu_id'];
    $quantity = 1;

    // Check if the item is already in the cart
    $sql = "SELECT * FROM cart WHERE menu_id = $menu_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Update quantity if item is already in the cart
        $sql = "UPDATE cart SET quantity = quantity + 1 WHERE menu_id = $menu_id";
    } else {
        // Insert new item into the cart
        $sql = "INSERT INTO cart (menu_id, quantity) VALUES ($menu_id, $quantity)";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Item added to cart successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid request method.";
}
$conn->close();
?>