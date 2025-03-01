<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php'; // Your database connection

// Fetch categories for the dropdown
$categorySql = "SELECT * FROM categories";
$categoryResult = $conn->query($categorySql);

// Handle product creation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image']; // Handle file uploads as needed
    $category_id = $_POST['category_id'];
    $stock_quantity = $_POST['stock_quantity'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    // Use a prepared statement to prevent SQL injection
    $sql = "INSERT INTO products (name, price, description, image, category_id, stock_quantity, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsiis", $name, $description, $price, $image, $category_id, $stock_quantity, $is_active);

    if ($stmt->execute()) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-6">
        <h1 class="text-2xl font-semibold mb-4">Add New Product</h1>
        <form method="POST" action="" class="bg-white p-4 rounded shadow-md">
            <input type="text" name="name" placeholder="Product Name" required class="border p-2 mb-2 w-full">
            <input type="text" name="price" placeholder="Price" required class="border p-2 mb-2 w-full">
            <textarea name="description" placeholder="Description" required class="border p-2 mb-2 w-full"></textarea>
            <input type="text" name="image" placeholder="Image URL" required class="border p-2 mb-2 w-full">

            <select name="category_id" class="border p-2 mb-2 w-full" required>
                <option value="">Select Category</option>
                <?php while ($category = $categoryResult->fetch_assoc()): ?>
                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['category_name']) ?></option>
                <?php endwhile; ?>
            </select>

            <input type="number" name="stock_quantity" placeholder="Stock Quantity" required class="border p-2 mb-2 w-full">
            
            <div class="mb-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" class="form-checkbox" checked>
                    <span class="ml-2">Active</span>
                </label>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Add Product</button>
        </form>
    </div>
</body>
</html>