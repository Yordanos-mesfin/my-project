<?php
// Start the session if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Update user information in the database
    $update_sql = "UPDATE users SET username='$username', email='$email' WHERE id='$user_id'";
    if ($conn->query($update_sql) === TRUE) {
        $success_message = "Profile updated successfully.";
        // Update the session variable as well
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email; // Update email in session
    } else {
        $error_message = "Error updating profile: " . $conn->error;
    }

    // Handle password update if current password is provided
    if (!empty($current_password) && !empty($new_password) && !empty($confirm_password)) {
        if (password_verify($current_password, $user['password'])) {
            if ($new_password === $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_password_sql = "UPDATE users SET password='$hashed_password' WHERE id='$user_id'";
                if ($conn->query($update_password_sql) === TRUE) {
                    $success_message = "Password updated successfully.";
                } else {
                    $error_message = "Error updating password: " . $conn->error;
                }
            } else {
                $error_message = "New passwords do not match.";
            }
        } else {
            $error_message = "Current password is incorrect.";
        }
    }
}

// Determine the appropriate dashboard link
$dashboard_link = (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') ? 'admin.php' : 'customer_dashboard.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <h2 class="text-2xl font-semibold text-center mb-6">User Profile</h2>
        <div class="bg-white p-6 rounded shadow-md">
            <form method="POST" action="">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username</label>
                    <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                </div>
                <div class="mb-4">
                    <label for="current_password" class="block text-gray-700">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                </div>
                <div class="mb-4">
                    <label for="new_password" class="block text-gray-700">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                </div>
                <div class="mb-4">
                    <label for="confirm_password" class="block text-gray-700">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                </div>

                <?php if (isset($success_message)): ?>
                    <p class="text-green-600 text-center mb-4"><?= htmlspecialchars($success_message) ?></p>
                <?php endif; ?>
                <?php if (isset($error_message)): ?>
                    <p class="text-red-600 text-center mb-4"><?= htmlspecialchars($error_message) ?></p>
                <?php endif; ?>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500 transition duration-300">Update Profile</button>
            </form>
            <p class="mt-4 text-center"><a href="<?= $dashboard_link ?>" class="text-blue-600 underline">Back to Dashboard</a></p>
        </div>
    </div>
</body>
</html>