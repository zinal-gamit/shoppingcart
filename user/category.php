<!-- categories.php -->
<?php
$mysqli = new mysqli("localhost", "root", "", "shoppingcart");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch categories
$categories = $mysqli->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background: #fff;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        li:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
            display: block;
        }

        a:hover {
            color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Categories</h1>
    <ul>
        <?php while ($category = $categories->fetch_assoc()): ?>
            <li>
                <a href="product_detail.php?category_id=<?= $category['id'] ?>">
                    <?= htmlspecialchars($category['name']) ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
