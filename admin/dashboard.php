<?php
$mysqli = new mysqli("localhost", "root", "", "shoppingcart");
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
    max-width: 600px;
    margin: 100px auto; /* Center container vertically */
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

.nav-links {
    display: flex;
    flex-direction: column;
    gap: 15px; /* Spacing between links */
}

.nav-button {
    display: inline-block;
    padding: 12px 20px;
    background-color: #4CAF50; /* Button color */
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s; /* Smooth transition for hover effect */
    font-size: 16px;
}

.nav-button:hover {
    background-color: #45a049; /* Darker green on hover */
}

.logout {
    background-color: #f44336; /* Red color for logout */
}

.logout:hover {
    background-color: #e53935; /* Darker red on hover */
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Admin Dashboard</h1>
        <nav class="nav-links">
            <a href="categories/manage_categories.php" class="nav-button">Manage Categories</a>
            <a href="products/manage_products.php" class="nav-button">Manage Products</a>
            <a href="logout.php" class="nav-button logout">Logout</a>
        </nav>
    </div>
</body>
</html>
