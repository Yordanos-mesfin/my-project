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

// Handle adding to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $user_id = $_SESSION['user_id'];

    // Check if the product is already in the cart
    $check_sql = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $user_id, $product_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Product already exists in the cart, update quantity
        $update_sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $user_id, $product_id);
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        // Product not in cart, insert it
        $insert_sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ii", $user_id, $product_id);
        $insert_stmt->execute();
        $insert_stmt->close();
    }

    $_SESSION['message'] = "Product added to cart!";
    header("Location: customer_dashboard.php?page=products"); // Redirect to products page
    exit();
}

$sql = "SELECT * FROM products WHERE is_active = 1"; // Only fetch active products
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="container mx-auto py-6">
        <h2 class="text-2xl font-semibold mb-4">Products List</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            if ($result->num_rows > 0) {
                while ($product = $result->fetch_assoc()) {
                    $imageURL = htmlspecialchars($product['image']);
                    echo "<div class='bg-white p-4 rounded shadow'>
                            <img src='$imageURL' alt='" . htmlspecialchars($product['name']) . "' class='w-full h-48 object-cover mb-2 rounded'>
                            <h3 class='text-lg font-semibold'>" . htmlspecialchars($product['name']) . "</h3>
                            <p class='text-gray-700'>Price: $" . htmlspecialchars(number_format($product['price'], 2)) . "</p>
                            <form method='POST' action='customer_dashboard.php?page=products' class='mt-4'>
                                <input type='hidden' name='product_id' value='" . htmlspecialchars($product['id']) . "'>
                                <button type='submit' class='bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 transition duration-300'>
                                    Add to Cart
                                </button>
                            </form>
                          </div>";
                }
            } else {
                echo "<p class='text-center py-4'>No products available at the moment.</p>";
            }
            ?>
        </div>
    </div>

    <footer class="bg-gray-800 text-white text-center py-4">
        <p>&copy; 2025 E-Commerce Site</p>
    </footer>
</body>
</html>