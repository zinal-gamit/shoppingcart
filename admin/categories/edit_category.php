<?php
$mysqli = new mysqli("localhost", "root", "", "shoppingcart");
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
}

$id = $_GET['id'];
$stmt = $mysqli->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();

if (isset($_POST['edit_category'])) {
    $name = $_POST['name'];
    $stmt = $mysqli->prepare("UPDATE categories SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();
    header("Location: manage_categories.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <style>
        /* Add basic styling for the page */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
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
            padding: 40px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 15px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: purple;
        }

        a {
            display: inline-block;
            margin-top: 15px;
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
        <h1>Edit Category</h1>
        <form method="post">
            <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" required />
            <button type="submit" name="edit_category">Update Category</button>
        </form>
        <a href="manage_categories.php">Back to Manage Categories</a>
    </div>
</body>
</html>
