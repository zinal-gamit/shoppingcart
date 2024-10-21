<?php
$mysqli = new mysqli("localhost", "root", "", "shoppingcart");
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
}

$id = $_GET['id'];
$stmt = $mysqli->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (isset($_POST['edit_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    // Handle image upload
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target = "../upload/product_images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = $product['image']; // Keep the existing image if no new one is uploaded
    }

    $stmt = $mysqli->prepare("UPDATE products SET name = ?, price = ?, category_id = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sdisi", $name, $price, $category_id, $image, $id);
    $stmt->execute();
    header("Location: manage_products.php");
}

$categories = $mysqli->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 500px;
        }

        h1 {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"], input[type="number"], select, input[type="file"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            text-align: center;
            text-decoration: none;
            color: #2196F3;
            font-size: 14px;
        }

        a:hover {
            color: #1976D2;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" placeholder="Product Name" required />
            <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" placeholder="Product Price" required />
            <select name="category_id" required>
                <?php while ($category = $categories->fetch_assoc()) : ?>
                    <option value="<?= $category['id'] ?>" <?= ($category['id'] == $product['category_id']) ? 'selected' : '' ?>><?= htmlspecialchars($category['name']) ?></option>
                <?php endwhile; ?>
            </select>
            <input type="file" name="image" />
            <button type="submit" name="edit_product">Update Product</button>
        </form>
        <a href="manage_products.php">Back to Manage Products</a>
    </div>
</body>
</html>
