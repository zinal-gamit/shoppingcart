<?php
$mysqli = new mysqli("localhost", "root", "", "shoppingcart");
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
}

if (isset($_POST['add_category'])) {
    $name = $_POST['name'];
    $stmt = $mysqli->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->execute([$name]);
    header("Location: manage_categories.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
   <style>
    /* style.css */

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    color: #333;
}

.container {
    max-width: 600px;
    margin: 50px auto; /* Center the container */
    padding: 20px;
    background-color: white;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #4CAF50; /* Green color */
    margin-bottom: 20px;
}

.category-form {
    display: flex;
    flex-direction: column;
}

.category-form input[type="text"] {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.category-form button {
    padding: 10px;
    background-color: #4CAF50; /* Button color */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 16px;
}

.category-form button:hover {
    background-color: #45a049; /* Darker green on hover */
}

.back-link {
    display: block;
    text-align: center;
    margin-top: 20px;
    color: #333;
    text-decoration: none;
    font-size: 16px;
}

.back-link:hover {
    text-decoration: underline; /* Underline on hover */
}

   </style>
</head>
<body>
    <div class="container">
        <h1>Add New Category</h1>
        <form method="post" class="category-form">
            <input type="text" name="name" placeholder="Category Name" required />
            <button type="submit" name="add_category">Add Category</button>
        </form>
        <a href="manage_categories.php" class="back-link">Back to Manage Categories</a>
    </div>
</body>
</html>
