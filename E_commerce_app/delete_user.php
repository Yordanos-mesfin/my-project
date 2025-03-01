<?php
session_start();
include 'db.php';

// Check if the user is an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php"); // Redirect if not admin
    exit();
}

// Check if ID is provided
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Prepare and execute the deletion query
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    
    if ($stmt->execute()) {
        header("Location: admin.php"); // Redirect to the admin page after deletion
        exit();
    } else {
        echo "Error deleting user: " . $stmt->error; // Display error if something goes wrong
    }

    $stmt->close();
} else {
    echo "Invalid request."; // Handle the case where no ID is provided
}

$conn->close();
?>
