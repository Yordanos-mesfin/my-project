<?php
// Start the session if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM order_history WHERE user_id = ? ORDER BY order_date DESC"; // Order by date
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-xl">Your Order History</h1>
        </div>
    </header>

    <div class="container mx-auto py-6">
        <h2 class="text-2xl font-semibold mb-4">Order History</h2>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="bg-green-200 text-green-800 p-4 rounded mb-4 text-center">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="py-2 px-4 border-b">Order ID</th>
                    <th class="py-2 px-4 border-b">Order Date</th>
                    <th class="py-2 px-4 border-b">Total Amount</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($order = $result->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b"><?= htmlspecialchars($order['id']) ?></td>
                        <td class="py-2 px-4 border-b"><?= htmlspecialchars($order['order_date']) ?></td>
                        <td class="py-2 px-4 border-b">$<?= htmlspecialchars(number_format($order['total_amount'], 2)) ?></td>
                        <td class="py-2 px-4 border-b"><?= htmlspecialchars($order['status']) ?></td>
                        <td class="py-2 px-4 border-b">
                            <?php if ($order['status'] !== 'Completed'): ?>
                                <a href="payment.php?order_id=<?= htmlspecialchars($order['id']) ?>" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-500">Pay Now</a>
                            <?php else: ?>
                                <span class="text-green-500">Completed</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-2">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>