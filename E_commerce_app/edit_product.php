<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php'; // Your database connection

// Fetch the product to edit
$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $stock_quantity = $_POST['stock_quantity'];
    $category_id = $_POST['category_id'];
    $is_active = isset($_POST['is_active']) ? 1 : 0; // Checkbox for active status

    $sql = "UPDATE products SET name=?, price=?, description=?, image=?, stock_quantity=?, category_id=?, is_active=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdssiiii", $name, $price, $description, $image, $stock_quantity, $category_id, $is_active, $id);

    if ($stmt->execute()) {
        echo "Product updated successfully!";
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
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-6">
        <h1 class="text-2xl font-semibold mb-4">Edit Product</h1>
        <form method="POST" action="" class="bg-white p-4 rounded shadow-md">
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required class="border p-2 mb-2 w-full" placeholder="Product Name">
            <input type="number" name="price" value="<?= $product['price'] ?>" required class="border p-2 mb-2 w-full" placeholder="Price">
            <textarea name="description" required class="border p-2 mb-2 w-full" placeholder="Description"><?= htmlspecialchars($product['description']) ?></textarea>
            <input type="text" name="image" value="<?= $product['image'] ?>" required class="border p-2 mb-2 w-full" placeholder="Image URL">
            <input type="number" name="stock_quantity" value="<?= $product['stock_quantity'] ?>" required class="border p-2 mb-2 w-full" placeholder="Stock Quantity">
            
            <select name="category_id" class="border p-2 mb-2 w-full" required>
                <option value="">Select Category</option>
                <?php
                // Fetch categories for the dropdown
                $categorySql = "SELECT * FROM categories";
                $categoryResult = $conn->query($categorySql);
                while ($category = $categoryResult->fetch_assoc()): ?>
                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($category['category_name']) ?></option>
                <?php endwhile; ?>
            </select>

            <label>
                <input type="checkbox" name="is_active" <?= $product['is_active'] ? 'checked' : '' ?>> Active
            </label>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Update Product</button>
        </form>
    </div>
</body>
</html>