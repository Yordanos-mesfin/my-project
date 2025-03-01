<?php
// Start the session if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session
}

include 'db.php'; // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Fetch product details for the user's cart
$user_id = $_SESSION['user_id'];
$products = [];

// Query to fetch cart items for the logged-in user
$sql = "SELECT c.quantity, p.id, p.name, p.price, p.image 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all products in the cart
while ($product = $result->fetch_assoc()) {
    $products[] = $product; // Store product details along with quantity
}

$stmt->close();

// Handle updating product quantity
if (isset($_POST['update_id']) && isset($_POST['quantity'])) {
    $update_id = intval($_POST['update_id']);
    $quantity = intval($_POST['quantity']);
    
    // Update the quantity in the database
    $update_sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("iii", $quantity, $user_id, $update_id);
    if ($update_stmt->execute()) {
        $_SESSION['message'] = "Quantity updated successfully!";
    } else {
        $_SESSION['message'] = "Error updating quantity.";
    }
    $update_stmt->close();
}

// Handle removing items from the cart
if (isset($_POST['remove_id'])) {
    $remove_id = intval($_POST['remove_id']);
    
    // Delete the item from the cart
    $remove_sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
    $remove_stmt = $conn->prepare($remove_sql);
    $remove_stmt->bind_param("ii", $user_id, $remove_id);
    if ($remove_stmt->execute()) {
        $_SESSION['message'] = "Product removed from cart!";
    } else {
        $_SESSION['message'] = "Error removing product.";
    }
    $remove_stmt->close();
}

// Display any messages
if (isset($_SESSION['message'])) {
    echo "<div class='bg-green-200 text-green-800 p-4 rounded mb-4 text-center'>" . htmlspecialchars($_SESSION['message']) . "</div>";
    unset($_SESSION['message']); // Clear message after displaying
}

// Calculate total price
$total_price = 0;
foreach ($products as $product) {
    $total_price += $product['price'] * $product['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <h2 class="text-2xl mb-4">Your Shopping Cart</h2>
    <?php if (empty($products)): ?>
        <p>Your cart is empty. <a href="customer_dashboard.php?page=products" class="text-blue-500">Continue shopping</a>.</p>
    <?php else: ?>
        <ul class="bg-white p-4 rounded shadow" id="cart-items">
            <?php foreach ($products as $product): ?>
                <li class="flex justify-between items-center mb-4" data-id="<?= htmlspecialchars($product['id']) ?>">
                    <span>Product: <?= htmlspecialchars($product['name']) ?> (ID: <?= htmlspecialchars($product['id']) ?>)</span>
                    <span>Price: $<?= htmlspecialchars(number_format($product['price'], 2)) ?></span>
                    <span>Quantity: 
                        <form method="POST" action="?page=cart" class="inline-block">
                            <input type="number" name="quantity" value="<?= htmlspecialchars($product['quantity']) ?>" min="1" class="w-16 text-center border rounded">
                            <input type="hidden" name="update_id" value="<?= htmlspecialchars($product['id']) ?>">
                            <button type="submit" class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-500">Update</button>
                        </form>
                    </span>
                    <form method="POST" action="?page=cart" class="inline-block">
                        <input type="hidden" name="remove_id" value="<?= htmlspecialchars($product['id']) ?>">
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-500">Remove</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="mt-4 bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold">Total Price: $<?= htmlspecialchars(number_format($total_price, 2)) ?></h3>
        </div>
    <?php endif; ?>
    <a href="customer_dashboard.php?page=checkout" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Proceed to Checkout</a>
</body>
</html>