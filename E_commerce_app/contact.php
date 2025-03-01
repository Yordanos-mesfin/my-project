<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - E-Commerce Site</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl">E-Commerce</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="index.php" class="hover:underline">Home</a></li>
                    <li><a href="about.php" class="hover:underline">About Us</a></li>
                    <li><a href="contact.php" class="hover:underline">Contact</a></li>
                    <li><a href="logout.php" class="hover:underline">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container mx-auto py-6">
        <h2 class="text-2xl font-semibold mb-4">Contact Us</h2>
        <p class="mb-4">We would love to hear from you! Please fill out the form below to get in touch with us.</p>

        <form action="send_message.php" method="POST" class="bg-white p-4 rounded shadow-md">
            <input type="text" name="name" placeholder="Your Name" required class="border p-2 mb-2 w-full" />
            <input type="email" name="email" placeholder="Your Email" required class="border p-2 mb-2 w-full" />
            <textarea name="message" placeholder="Your Message" required class="border p-2 mb-2 w-full" rows="5"></textarea>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Send Message</button>
        </form>
    </div>

    <footer class="bg-gray-800 text-white text-center py-4">
        <p>&copy; 2025 E-Commerce Site</p>
    </footer>
</body>
</html>