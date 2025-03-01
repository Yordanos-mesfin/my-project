<?php
session_start();
include 'db.php'; // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_POST['remove_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized or missing parameters.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$remove_id = intval($_POST['remove_id']);

// Remove the product from the cart in the database
$delete_sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("ii", $user_id, $remove_id);

if ($delete_stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error removing product from cart.']);
}

$delete_stmt->close();
?>
