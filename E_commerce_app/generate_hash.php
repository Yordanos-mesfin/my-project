<?php
// The password you want to hash
$password = 'Met@2025'; // Replace with your desired password

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Output the hashed password
echo $hashed_password;
?>