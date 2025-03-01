<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php'; // Your database connection

$id = $_GET['id'];
$sql = "DELETE FROM products WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    echo "Product deleted successfully!";
} else {
    echo "Error: " . $conn->error;
}

// Redirect back to the admin page
header("Location: admin.php");
exit();
?>