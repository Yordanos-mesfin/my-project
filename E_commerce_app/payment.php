<?php
// Start the session if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_GET['order_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = intval($_GET['order_id']);

// Fetch order details to display
$sql = "SELECT * FROM order_history WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$order) {
    $_SESSION['message'] = "Order not found.";
    header("Location: customer_dashboard.php?page=order_history");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="container mx-auto py-6">
        <h2 class="text-2xl font-semibold mb-4">Payment for Order #<?= htmlspecialchars($order['id']) ?></h2>
        <p class="text-lg mb-4">Total Amount: $<?= htmlspecialchars(number_format($order['total_amount'], 2)) ?></p>
        <form method="POST" action="process_payment.php" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']) ?>">

            <label for="card_number" class="block text-sm font-medium mb-2">Card Number:</label>
            <input type="text" name="card_number" id="card_number" required class="border border-gray-300 p-2 mb-4 w-full rounded focus:outline-none focus:ring focus:ring-blue-200">

            <label for="expiry_date" class="block text-sm font-medium mb-2">Expiry Date:</label>
            <div class="flex mb-4">
                <select name="expiry_month" id="expiry_month" required class="border border-gray-300 p-2 w-1/2 mr-2 rounded focus:outline-none focus:ring focus:ring-blue-200">
                    <option value="">Month</option>
                    <?php for ($month = 1; $month <= 12; $month++): ?>
                        <option value="<?= str_pad($month, 2, '0', STR_PAD_LEFT) ?>"><?= date('F', mktime(0, 0, 0, $month, 1)) ?></option>
                    <?php endfor; ?>
                </select>
                <select name="expiry_year" id="expiry_year" required class="border border-gray-300 p-2 w-1/2 rounded focus:outline-none focus:ring focus:ring-blue-200">
                    <option value="">Year</option>
                    <?php 
                    $current_year = date('Y');
                    for ($year = $current_year; $year <= $current_year + 10; $year++): ?>
                        <option value="<?= $year ?>"><?= $year ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <label for="cvv" class="block text-sm font-medium mb-2">CVV:</label>
            <input type="text" name="cvv" id="cvv" required class="border border-gray-300 p-2 mb-4 w-full rounded focus:outline-none focus:ring focus:ring-blue-200">

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 transition duration-200">Proceed to Pay</button>
        </form>

        <!-- Back to Dashboard Button -->
        <a href="customer_dashboard.php?page=order_history" class="mt-4 inline-block bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-500 transition duration-200">Back to Dashboard</a>
    </div>

    <footer class="bg-gray-800 text-white text-center py-4">
        <p>&copy; 2025 E-Commerce Site</p>
    </footer>
</body>
</html>