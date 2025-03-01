<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT cart.*, products.name, products.price FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id='$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
</head>
<body>
    <h2>Your Cart</h2>
    <table>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        <?php
        $total = 0;
        while ($row = $result->fetch_assoc()) {
            $item_total = $row['quantity'] * $row['price'];
            $total += $item_total;
            echo "<tr>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['quantity']) . "</td>
                <td>$" . htmlspecialchars($row['price']) . "</td>
                <td>$$item_total</td>
            </tr>";
        }
        ?>
    </table>
    <h3>Total: $<?= number_format($total, 2) ?></h3>
    <a href="checkout.php">Proceed to Checkout</a>
    <a href="products.php">Continue Shopping</a>
</body>
</html>