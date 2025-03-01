<?php
session_start();
include 'db.php';

// Check if the user is logged in and if the order ID is provided
if (!isset($_SESSION['user_id']) || !isset($_POST['order_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = intval($_POST['order_id']);

// Fetch the order details
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

// Here you would implement your actual payment processing logic
// For demonstration, we'll assume the payment is always successful

// Update order status to 'Completed'
$update_sql = "UPDATE order_history SET status = 'Completed' WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("i", $order_id);
$update_stmt->execute();
$update_stmt->close();

// Set a success message
$_SESSION['message'] = "Payment processed successfully!";

// Redirect to the dashboard
header("Location: customer_dashboard.php?page=order_history");
exit();