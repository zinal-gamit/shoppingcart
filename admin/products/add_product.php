<?php
$mysqli = new mysqli(hostname: "localhost", username: "root", password: "", database: "shoppingcart");
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch all categories for the dropdown
$result = $mysqli->query("SELECT * FROM categories");
$categories = []; // Array to hold categories
while ($row = $result->fetch_assoc()) {
    $categories[] = $row; // Add each category to the array
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $image = $_FILES['image']['name'];

    // Debugging: Print category_id for verification
    echo "Selected Category ID: " . htmlspecialchars($category_id) . "<br>";

    // Check if the selected category_id exists
    $categoryCheck = $mysqli->prepare("SELECT * FROM categories WHERE id = ?");
    $categoryCheck->bind_param("i", $category_id);
    $categoryCheck->execute();
    $resultCheck = $categoryCheck->get_result();

    if ($resultCheck->num_rows === 0) {
        die("Error: The selected category does not exist.");
    }

    // Move uploaded image to the specified directory
    move_uploaded_file($_FILES['image']['tmp_name'], "../upload/product_images/" . $image);

    // Insert product into the database
    $stmt = $mysqli->prepare("INSERT INTO products (name, price, category_id, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $name, $price, $category_id, $image);
    
    if ($stmt->execute()) {
        echo "<p style='color: green;'>Product added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
    margin: 50px auto; /* Center container */
    padding: 20px;
    background-color: white;
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

h1 {
    color: #4CAF50; /* Green color for the header */
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px; /* Spacing between form fields */
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"],
input[type="number"],
select {
    width: 100%;
    padding: 10px; /* Padding for inputs */
    border: 1px solid #ccc; /* Light grey border */
    border-radius: 4px; /* Rounded corners */
    box-sizing: border-box; /* Ensure padding is included in width */
}

input[type="file"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4CAF50; /* Button color */
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 20px; /* Spacing above the button */
    transition: background-color 0.3s; /* Smooth transition for hover effect */
}

.btn:hover {
    background-color: #45a049; /* Darker green on hover */
}

.submit-btn {
    width: 100%; /* Full width for submit button */
}

.back-btn {
    background-color: #2196F3; /* Blue color for back button */
    margin-top: 10px; /* Spacing above back button */
}

.back-btn:hover {
    background-color: #1976D2; /* Darker blue on hover */
}

p {
    text-align: center; /* Center success/error messages */
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Add Product</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" name="price" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="category_id">Category:</label>
                <select name="category_id" required>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" name="image" required>
            </div>

            <input type="submit" value="Add Product" class="btn submit-btn">
        </form>
        <a href="manage_products.php" class="btn back-btn">Back to Manage Products</a>
    </div>
</body>
</html>
