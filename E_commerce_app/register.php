<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    $sql = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$password', '$email', 'customer')";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='text-green-600'>Registration successful! You can now <a href='login.php' class='text-blue-600 underline'>login</a>.</p>";
    } else {
        echo "<p class='text-red-600'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php include 'header.php'; // Include the header file ?>
    
    <div class="container mx-auto mt-10">
        <h2 class="text-2xl font-semibold text-center mb-6">Register</h2>
        <div class="bg-white p-8 rounded-lg shadow-md max-w-md mx-auto"> <!-- Increased padding and max width -->
            <form method="POST" action="">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username</label>
                    <input type="text" name="username" id="username" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-500 transition duration-300">Register</button>
            </form>
            <p class="mt-4 text-center">Already have an account? <a href="login.php" class="text-blue-600 underline">Login here</a>.</p>
        </div>
    </div>

    <?php include 'footer.php'; // Include the footer file ?>
</body>
</html>