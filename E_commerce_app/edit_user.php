<?php
session_start();
include 'db.php';

// Check if the user is an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php"); // Redirect if not admin
    exit();
}

// Fetch user data if ID is set
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $userResult = $stmt->get_result();

    if ($userResult->num_rows === 0) {
        die("User not found.");
    }

    $user = $userResult->fetch_assoc();
} else {
    die("Invalid request.");
}

// Handle user update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $updateUserSql = "UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($updateUserSql);
    $stmt->bind_param("sssi", $username, $email, $role, $userId);
    $stmt->execute();

    header("Location: admin.php"); // Redirect back to admin page after update
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - E-Commerce Site</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <header class="bg-blue-600 text-white py-4">
        <h1 class="text-center text-2xl">Edit User</h1>
        <div class="text-center mt-2">
            <a href="logout.php" class="text-white hover:underline">Logout</a>
        </div>
    </header>

    <div class="container mx-auto py-6">
        <form action="" method="POST" class="bg-white p-4 rounded shadow-md">
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required class="border p-2 mb-2 w-full" />
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required class="border p-2 mb-2 w-full" />
            <select name="role" class="border p-2 mb-2 w-full">
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="vendor" <?= $user['role'] === 'vendor' ? 'selected' : '' ?>>Vendor</option>
                <option value="customer" <?= $user['role'] === 'customer' ? 'selected' : '' ?>>Customer</option>
            </select>
            <button type="submit" name="update_user" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Update User</button>
        </form>
    </div>

    <footer class="bg-blue-600 text-white text-center py-4">
        <p>&copy; 2025 E-Commerce Site</p>
    </footer>
</body>
</html>