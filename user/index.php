<?php
$mysqli = new mysqli("localhost", "root", "", "shoppingcart");
session_start();

// Fetch all categories
$result = $mysqli->query("SELECT * FROM categories");
$categories = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Shopping Cart</title>
    <style>
        /* style.css */

body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    color: #333;
}

header {
    background-color: #4CAF50;
    color: white;
    padding: 20px;
    text-align: center;
}

h1 {
    margin: 0;
}

.user-actions {
    margin-top: 10px;
}

.user-actions a {
    color: white;
    margin: 0 10px;
    text-decoration: none;
    font-weight: bold;
}

.user-actions a:hover {
    text-decoration: underline;
}

main {
    padding: 20px;
}

.categories {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.category {
    background: white;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
    transition: transform 0.2s;
    text-align: center;
}

.category:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.category h2 {
    font-size: 1.5em;
    margin-bottom: 10px;
}

.category a {
    display: inline-block;
    padding: 10px 15px;
    background-color: #4CAF50;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.2s;
}

.category a:hover {
    background-color: #45a049;
}

    </style>
</head>
<body>
    <header>
        <h1>Welcome to the Shopping Cart</h1>
        <nav class="user-actions">
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <div class="categories">
            <?php foreach ($categories as $category) : ?>
                <div class="category">
                    <h2><?= htmlspecialchars($category['name']) ?></h2>
                    <a href="category.php?id=<?= $category['id'] ?>">View Products</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
