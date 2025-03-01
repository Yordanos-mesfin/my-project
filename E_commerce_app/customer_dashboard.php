<?php
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch user information from the database (optional)
include 'db.php';
$user_id = $_SESSION['user_id'];
$sql = "SELECT username FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Determine the current page from the URL parameter
$current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <?php include 'header.php'; // Include the header file ?>
    
    <div class="flex">
        <!-- Sidebar -->
        <nav class="w-1/4 bg-gradient-to-b from-blue-500 to-blue-300 shadow-md h-screen p-6">
            <h2 class="text-2xl font-semibold text-white mb-6">Dashboard</h2>
            <ul class="space-y-4">
                <li><a href="?page=profile" class="text-white hover:bg-blue-400 block p-2 rounded transition">View Profile</a></li>
                <li><a href="?page=products" class="text-white hover:bg-blue-400 block p-2 rounded transition">Browse Products</a></li>
                <li><a href="?page=cart" class="text-white hover:bg-blue-400 block p-2 rounded transition">View Shopping Cart</a></li>
                <li><a href="?page=checkout" class="text-white hover:bg-blue-400 block p-2 rounded transition">Checkout</a></li>
                <li><a href="?page=order_history" class="text-white hover:bg-blue-400 block p-2 rounded transition">Order History</a></li>
                <li><a href="logout.php" class="text-red-300 hover:bg-red-600 block p-2 rounded transition">Logout</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome to Your Dashboard</h1>
            <p class="text-lg text-gray-700 mb-4">Hello, <span class="font-semibold text-blue-600"><?= htmlspecialchars($user['username']) ?></span>! This is your customer dashboard.</p>
            
            <!-- Dynamic Content Area -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <?php
                // Include the appropriate content based on the selected page
                switch ($current_page) {
                    case 'profile':
                        include 'profile.php'; // Create this file with profile details
                        break;
                    case 'order_history':
                        include 'order_history.php'; // Create this file with order history
                        break;
                    case 'products':
                        include 'products.php'; // Create this file with product listings
                        break;
                    case 'cart':
                        include 'cart.php'; // Create this file with cart details
                        break;
                    case 'checkout':
                        include 'checkout.php'; // Create this file with checkout process
                        break;
                    case 'payment':
                        include 'payment.php'; // Include payment processing
                        break;
                    default:
                        echo '<h3 class="text-xl font-semibold text-gray-800 mb-2">Your Features:</h3>';
                        echo '<p class="text-gray-600">Use the sidebar to navigate through your account.</p>';
                        break;
                }
                ?>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; // Include the footer file ?>
</body>
</html>