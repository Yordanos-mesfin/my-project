<?php
session_start();
include 'db.php';

// Check if the user is an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php"); // Redirect if not admin
    exit();
}

// Fetch all messages
$messageSql = "SELECT * FROM messages ORDER BY created_at DESC";
$messageResult = $conn->query($messageSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white p-4">
        <h1 class="text-xl">Admin Dashboard</h1>
    </header>

    <div class="container mx-auto py-6">
        <h2 class="text-2xl font-semibold mb-4">Contact Messages</h2>
        <table class="min-w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4">ID</th>
                    <th class="py-2 px-4">Name</th>
                    <th class="py-2 px-4">Email</th>
                    <th class="py-2 px-4">Message</th>
                    <th class="py-2 px-4">Received At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($message = $messageResult->fetch_assoc()): ?>
                    <tr>
                        <td class="border px-4 py-2"><?= $message['id'] ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($message['name']) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($message['email']) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($message['message']) ?></td>
                        <td class="border px-4 py-2"><?= $message['created_at'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>