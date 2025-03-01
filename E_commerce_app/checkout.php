<?php
// Start the session if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session
}

include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Add checkout logic here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

    // Retrieve cart items for the user
    $sql = "SELECT product_id, quantity FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Calculate total price
    $total_price = 0;
    foreach ($cart_items as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        
        // Fetch the product price from the products table
        $product_sql = "SELECT price FROM products WHERE id = ?";
        $product_stmt = $conn->prepare($product_sql);
        $product_stmt->bind_param("i", $product_id);
        $product_stmt->execute();
        $product_result = $product_stmt->get_result();
        $product = $product_result->fetch_assoc();
        $total_price += $product['price'] * $quantity;
        $product_stmt->close();
    }

    // Process the order
    if (!empty($cart_items)) {
        // Insert order details into order_history
        $order_sql = "INSERT INTO order_history (user_id, total_amount, order_date, status) VALUES (?, ?, NOW(), 'Pending')";
        $order_stmt = $conn->prepare($order_sql);
        $order_stmt->bind_param("id", $user_id, $total_price);
        
        if ($order_stmt->execute()) {
            // Clear the user's cart after successful order placement
            $clear_cart_sql = "DELETE FROM cart WHERE user_id = ?";
            $clear_cart_stmt = $conn->prepare($clear_cart_sql);
            $clear_cart_stmt->bind_param("i", $user_id);
            $clear_cart_stmt->execute();
            $clear_cart_stmt->close();

            $_SESSION['message'] = "Order placed successfully!";
            header("Location: customer_dashboard.php?page=order_history"); // Redirect to order history
            exit();
        } else {
            $_SESSION['message'] = "There was an error placing your order.";
            header("Location: customer_dashboard.php?page=cart"); // Redirect back to cart
            exit();
        }
        $order_stmt->close();
    } else {
        $_SESSION['message'] = "Your cart is empty.";
        header("Location: customer_dashboard.php?page=cart"); // Redirect back to cart
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <h2>Checkout</h2>
    <form method="POST" action="">
        <p>Please confirm your order.</p>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Place Order</button>
    </form>
    <?php
    // Display any messages
    if (isset($_SESSION['message'])) {
        echo "<div class='bg-green-200 text-green-800 p-4 rounded mb-4 text-center'>" . htmlspecialchars($_SESSION['message']) . "</div>";
        unset($_SESSION['message']); // Clear message after displaying
    }
    ?>
</body>
</html>