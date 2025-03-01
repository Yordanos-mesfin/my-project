<?php
session_start();
include 'db.php';

// Check if the user is an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php"); // Redirect if not admin
    exit();
}

// Fetch all users for management
$userSql = "SELECT * FROM users";
$userResult = $conn->query($userSql);

// Fetch all products for management
$productSql = "SELECT * FROM products";
$productResult = $conn->query($productSql);

// Fetch all categories for the dropdown
$categorySql = "SELECT * FROM categories";
$categoryResult = $conn->query($categorySql);

// Fetch all messages
$messageSql = "SELECT * FROM messages ORDER BY created_at DESC";
$messageResult = $conn->query($messageSql);

// Handle user creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $insertUserSql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    $conn->query($insertUserSql);
    header("Location: admin.php"); // Redirect to the same page after creation
    exit();
}

// Handle product creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_product'])) {
    $productName = $_POST['product_name'];
    $price = $_POST['price'];
    $stockQuantity = $_POST['stock_quantity'];
    $description = $_POST['description'];
    $image = $_POST['image']; // Assuming you want to allow image URL
    $categoryId = $_POST['category_id'];

    $insertProductSql = "INSERT INTO products (name, price, stock_quantity, description, image, category_id) VALUES ('$productName', '$price', '$stockQuantity', '$description', '$image', '$categoryId')";
    $conn->query($insertProductSql);
    header("Location: admin.php"); // Redirect to the same page after creation
    exit();
}

// Handle category creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_category'])) {
    $categoryName = $_POST['category_name'];

    $insertCategorySql = "INSERT INTO categories (category_name) VALUES ('$categoryName')";
    $conn->query($insertCategorySql);
    header("Location: admin.php"); // Redirect to the same page after creation
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .content-section {
            display: none; /* Hide all sections initially */
        }
        .active {
            display: block; /* Show active section */
        }
        .button {
            background-color: #4CAF50; /* Green */
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #45a049; /* Darker green */
        }
        .table-header {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .table-row:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
    <script>
        function showSection(section) {
            // Hide all sections
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(s => s.classList.remove('active'));
            
            // Show the selected section
            document.getElementById(section).classList.add('active');
        }
    </script>
</head>
<body class="bg-gray-100">
    <header class="bg-gradient-to-r from-blue-500 to-blue-700 text-white py-4">
        <h1 class="text-center text-2xl">Admin Dashboard</h1>
        <div class="text-center mt-2">
            <a href="logout.php" class="text-white hover:underline">Logout</a>
            
        </div>
    </header>

    <div class="container mx-auto py-6 flex">
        <div class="w-1/4">
            <h2 class="text-lg font-semibold mb-4">Admin Options</h2>
            <ul class="bg-white p-4 rounded shadow">
                <li><a href="javascript:void(0);" onclick="showSection('createAdmin');" class="text-blue-600 hover:underline">Create New Admin</a></li>
                <li><a href="javascript:void(0);" onclick="showSection('createProduct');" class="text-blue-600 hover:underline">Create New Product</a></li>
                <li><a href="javascript:void(0);" onclick="showSection('createCategory');" class="text-blue-600 hover:underline">Create New Category</a></li>
                <li><a href="javascript:void(0);" onclick="showSection('productManagement');" class="text-blue-600 hover:underline">Product Management</a></li>
                <li><a href="javascript:void(0);" onclick="showSection('contactMessages');" class="text-blue-600 hover:underline">Contact Messages</a></li>
                <li><a href="profile.php" class="text-blue-600 hover:underline">User Profile</a></li>
            </ul>
        </div>

        <div class="w-3/4 ml-4">
            <h2 class="text-lg font-semibold mb-4">Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>

            <div id="createAdmin" class="content-section active">
                <h3 class="text-lg font-semibold mb-2">Create New Admin</h3>
                <form action="" method="POST" class="bg-white p-4 rounded shadow-md mb-4">
                    <input type="text" name="username" placeholder="Username" required class="border p-2 mb-2 w-full" />
                    <input type="email" name="email" placeholder="Email" required class="border p-2 mb-2 w-full" />
                    <input type="password" name="password" placeholder="Password" required class="border p-2 mb-2 w-full" />
                    <select name="role" class="border p-2 mb-2 w-full">
                        <option value="admin">Admin</option>
                        <option value="vendor">Vendor</option>
                        <option value="customer">Customer</option>
                    </select>
                    <button type="submit" name="create_user" class="button">Create User</button>
                </form>
            </div>

            <div id="createProduct" class="content-section">
                <h3 class="text-lg font-semibold mb-2">Create New Product</h3>
                <form action="" method="POST" class="bg-white p-4 rounded shadow-md mb-4">
                    <input type="text" name="product_name" placeholder="Product Name" required class="border p-2 mb-2 w-full" />
                    <input type="text" name="price" placeholder="Price" required class="border p-2 mb-2 w-full" />
                    <input type="number" name="stock_quantity" placeholder="Stock Quantity" required class="border p-2 mb-2 w-full" />
                    <textarea name="description" placeholder="Description" required class="border p-2 mb-2 w-full"></textarea>
                    <input type="text" name="image" placeholder="Image URL" required class="border p-2 mb-2 w-full" />
                    <select name="category_id" class="border p-2 mb-2 w-full" required>
                        <option value="">Select Category</option>
                        <?php while ($category = $categoryResult->fetch_assoc()): ?>
                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['category_name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                    <button type="submit" name="create_product" class="button">Create Product</button>
                </form>
            </div>

            <div id="createCategory" class="content-section">
                <h3 class="text-lg font-semibold mb-2">Create New Category</h3>
                <form action="" method="POST" class="bg-white p-4 rounded shadow-md mb-4">
                    <input type="text" name="category_name" placeholder="Category Name" required class="border p-2 mb-2 w-full" />
                    <button type="submit" name="create_category" class="button">Create Category</button>
                </form>
            </div>

            <div id="productManagement" class="content-section">
                <h3 class="text-lg font-semibold mb-2">Product Management</h3>
                <table class="min-w-full bg-white shadow-md rounded">
                    <thead>
                        <tr class="table-header">
                            <th class="py-2 px-4">ID</th>
                            <th class="py-2 px-4">Product Name</th>
                            <th class="py-2 px-4">Price</th>
                            <th class="py-2 px-4">Stock Quantity</th>
                            <th class="py-2 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($product = $productResult->fetch_assoc()): ?>
                            <tr class="table-row">
                                <td class="border px-4 py-2"><?= $product['id'] ?></td>
                                <td class="border px-4 py-2"><?= htmlspecialchars($product['name']) ?></td>
                                <td class="border px-4 py-2">$<?= htmlspecialchars(number_format($product['price'], 2)) ?></td>
                                <td class="border px-4 py-2"><?= htmlspecialchars($product['stock_quantity']) ?></td>
                                <td class="border px-4 py-2">
                                    <a href="edit_product.php?id=<?= $product['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
                                    <a href="delete_product.php?id=<?= $product['id'] ?>" class="text-red-600 hover:underline ml-2">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div id="contactMessages" class="content-section">
                <h3 class="text-lg font-semibold mb-2">Contact Messages</h3>
                <table class="min-w-full bg-white shadow-md rounded">
                    <thead>
                        <tr class="table-header">
                            <th class="py-2 px-4">ID</th>
                            <th class="py-2 px-4">Name</th>
                            <th class="py-2 px-4">Email</th>
                            <th class="py-2 px-4">Message</th>
                            <th class="py-2 px-4">Received At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($message = $messageResult->fetch_assoc()): ?>
                            <tr class="table-row">
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
        </div>
    </div>

    <footer class="bg-gradient-to-r from-blue-500 to-blue-700 text-white text-center py-4">
        <p>&copy; 2025 E-Commerce Site</p>
    </footer>
</body>
</html>