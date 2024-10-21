<?php
$mysqli = new mysqli("localhost", "root", "", "shoppingcart");
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

// Query to get all categories
$result = $mysqli->query("SELECT * FROM categories");
$categories = []; // Array to hold categories
while ($row = $result->fetch_assoc()) {
    $categories[] = $row; // Add each category to the array
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
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
    max-width: 800px;
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
    background-color: #4CAF50; /* Green color for edit */
}

.edit:hover {
    background-color: #45a049; /* Darker green on hover */
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

    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Categories</h1>
        <a href="add_category.php" class="btn">Add New Category</a>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category) : ?>
                    <tr>
                        <td><?= htmlspecialchars($category['name']) ?></td>
                        <td>
                        <a href="edit_category.php?id=<?= $category['id'] ?>" class="action-btn edit">Edit</a>
                            <a href="delete_category.php?id=<?= $category['id'] ?>" class="action-btn delete">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="../dashboard.php" class="btn back">Back to Dashboard</a>
    </div>
</body>
</html>
