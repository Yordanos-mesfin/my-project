<?php
include 'db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_role'] = $row['role'];
            $_SESSION['username'] = $row['username']; // Store username in session

            // Redirect based on user role
            if ($row['role'] === 'admin') {
                header("Location: admin.php"); // Redirect to admin page
            } else {
                header("Location: customer_dashboard.php"); // Redirect to customer dashboard
            }
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <?php include 'header.php'; // Include the header file ?>

    <div class="container mx-auto mt-10">
        <h2 class="text-2xl font-semibold text-center mb-6">Login</h2>
        <div class="bg-white p-8 rounded-lg shadow-md max-w-sm mx-auto">
            <form method="POST" action="">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username</label>
                    <input type="text" name="username" id="username" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                </div>
                <?php if (isset($error_message)): ?>
                    <p class="text-red-600 text-center mb-4"><?= htmlspecialchars($error_message) ?></p>
                <?php endif; ?>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500 transition duration-300">Login</button>
            </form>
            <p class="mt-4 text-center">Don't have an account? <a href="register.php" class="text-blue-600 underline">Register here</a>.</p>
            
        </div>
    </div>

    <?php include 'footer.php'; // Include the footer file ?>

</body>
</html>