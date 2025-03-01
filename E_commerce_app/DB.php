<?php
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default is empty for XAMPP
$dbname = "e_commerce_db"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>