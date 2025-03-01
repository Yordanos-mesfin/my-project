<?php
session_start();
include 'db.php'; // Include your database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Assume you have a cart table where you fetch the cart items
$cart_sql = "SELECT * FROM cart WHERE user_id='$user_id'";
$cart_result = $conn->query($cart_sql);

$total_amount = 0; // Initialize total amount

while ($row = $cart_result->fetch_assoc()) {
    $product_id = $row['product_id'];
    $quantity = $row['quantity'];

    // Fetch product details to calculate total
    $product_sql = "SELECT price FROM products WHERE id='$product_id'";
    $product_result = $conn->query($product_sql);
    $product = $product_result->fetch_assoc();

    // Ensure that price exists
    if ($product) {
        $total_amount += $product['price'] * $quantity; // Calculate total amount
    } else {
        echo "Product not found: $product_id";
        exit();
    }
}

// Save order in the order_history table
$sql = "INSERT INTO order_history (user_id, total_amount, status) VALUES ('$user_id', '$total_amount', 'completed')";

if ($conn->query($sql) === TRUE) {
    // Clear the cart
    $clear_cart_sql = "DELETE FROM cart WHERE user_id='$user_id'";
    $conn->query($clear_cart_sql);
    
    header("Location: order_history.php");
} else {
    // Handle error
    echo "Error: " . $sql . "<br>" . $conn->error;
}

exit();
?>