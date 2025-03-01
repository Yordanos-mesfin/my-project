<?php
session_start();
include 'db.php';

$categorySql = "SELECT * FROM categories";
$categoryResult = $conn->query($categorySql);

$categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
$sql = "SELECT * FROM products WHERE is_active = 1" . ($categoryId ? " AND category_id = $categoryId" : "");
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Site</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <?php include 'header.php'; // Include the header file ?>

    <div class="container mx-auto flex py-6">
        <div class="w-1/4 bg-white p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-2">Categories</h2>
            <ul>
                <?php while ($cat = $categoryResult->fetch_assoc()): ?>
                    <li class="mb-2">
                        <a href="index.php?category_id=<?= $cat['id'] ?>" class="text-blue-600 hover:underline"><?= htmlspecialchars($cat['category_name']) ?></a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="w-3/4 ml-6">
            <div class="flex justify-end mb-4">
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="login.php" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-500 transition duration-300 mx-2 shadow-md">Login</a>
                    <a href="register.php" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-500 transition duration-300 mx-2 shadow-md">Register</a>
                <?php else: ?>
                    <span class="text-gray-800 font-semibold mr-4">Welcome, <?= htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="logout.php" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-500 transition duration-300 mx-2 shadow-md">Logout</a>
                <?php endif; ?>
            </div>

            <h2 class="text-lg font-semibold mb-4">Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='bg-white p-4 rounded shadow'>
                                <h3 class='text-lg font-semibold'>" . htmlspecialchars($row['name']) . "</h3>
                                <p class='text-green-600 font-bold'>\$" . htmlspecialchars($row['price']) . "</p>
                                <img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "' class='w-full h-48 object-cover mb-2 rounded'>
                                <p class='text-gray-700'>" . htmlspecialchars($row['description']) . "</p>
                                <form method='POST' action='add_to_cart.php' style='display:inline;' onsubmit='return confirmAddToCart();'>
                                    <input type='hidden' name='product_id' value='" . $row['id'] . "'>
                                    <button type='submit' class='mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500'>Add to Cart</button>
                                </form>
                              </div>";
                    }
                } else {
                    echo "<p>No products found.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; // Include the footer file ?>

    <script>
        function confirmAddToCart() {
            return confirm("Are you sure you want to add this product to your cart?");
        }
    </script>
</body>
</html>