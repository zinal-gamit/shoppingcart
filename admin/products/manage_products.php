<?php
$mysqli = new mysqli("localhost", "root", "", "shoppingcart");
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
}

// Query to get all products with categories
$result = $mysqli->query("SELECT products.*, categories.name AS category_name FROM products JOIN categories ON products.category_id = categories.id");
$products = []; // Array to hold products
while ($row = $result->fetch_assoc()) {
    $products[] = $row; // Add each product to the array
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
   <style>
    /* style.css */

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4; /* Light grey background */
    margin: 0;
    padding: 0;
    color: #333;
}

.container {
    max-width: 900px;
    margin: 50px auto; /* Center container */
    padding: 20px;
    background-color: white;
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    text-align: center;
}

h1 {
    color: #4CAF50; /* Green color for the header */
    margin-bottom: 20px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4CAF50; /* Button color */
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-bottom: 20px;
    transition: background-color 0.3s; /* Smooth transition for hover effect */
}

.btn:hover {
    background-color: #45a049; /* Darker green on hover */
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px; /* Spacing above the table */
}

th, td {
    padding: 12px;
    border: 1px solid #ddd; /* Light grey border */
    text-align: left;
}

th {
    background-color: #f2f2f2; /* Light grey header */
    color: #333;
}

tr:nth-child(even) {
    background-color: #f9f9f9; /* Alternate row color */
}

.action-btn {
    padding: 6px 10px;
    color: white;
    text-decoration: none;
    border-radius: 3px;
    transition: background-color 0.3s; /* Smooth transition for hover effect */
}

.action-btn:hover {
    opacity: 0.8; /* Slightly dim the button on hover */
}

.edit {
    background-color: #2196F3; /* Blue color for edit */
    border: none;
}

.edit:hover {
    background-color: #1976D2; /* Darker blue on hover */
}

.delete {
    background-color: #f44336; /* Red color for delete */
}

.delete:hover {
    background-color: #e53935; /* Darker red on hover */
}

.back {
    background-color: #2196F3; /* Blue color for back */
}

.back:hover {
    background-color: #1976D2; /* Darker blue on hover */
}

img {
    border-radius: 5px; /* Rounded corners for images */
}

   </style>
</head>
<body>
    <div class="container">
        <h1>Manage Products</h1>
        <a href="add_product.php" class="btn">Add New Product</a>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= number_format($product['price'], 2) ?></td>
                        <td><?= htmlspecialchars($product['category_name']) ?></td>
                        <td><img src="../upload/product_images/<?= htmlspecialchars($product['image']) ?>" width="50" alt="<?= htmlspecialchars($product['name']) ?>" /></td>
                        <td>
                            <a href="edit_product.php?id=<?= $product['id'] ?>" class="action-btn edit">Edit</a>
                            <a href="delete_product.php?id=<?= $product['id'] ?>" class="action-btn delete">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="../dashboard.php" class="btn back">Back to Dashboard</a>
    </div>
</body>
</html>
