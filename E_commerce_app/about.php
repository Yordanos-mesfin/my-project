<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - E-Commerce Site</title>
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
        <h2 class="text-2xl font-semibold mb-4">About Us</h2>
        <p class="mb-4">Welcome to our e-commerce site! We are dedicated to providing you with the best online shopping experience.</p>
        <p class="mb-4">Our mission is to deliver quality products at affordable prices while ensuring customer satisfaction. We believe in building lasting relationships with our customers through excellent service.</p>
        <p class="mb-4">Thank you for choosing us for your shopping needs. We look forward to serving you!</p>
    </div>

    <footer class="bg-gray-800 text-white text-center py-4">
        <p>&copy; 2025 E-Commerce Site</p>
    </footer>
</body>
</html>