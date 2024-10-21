<?php
$mysqli = new mysqli("localhost", "root", "", "shoppingcart");
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL statement
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
    // Bind parameters
    $stmt->bind_param("s", $email);
    // Execute the statement
    $stmt->execute();
    // Get the result
    $result = $stmt->get_result();
    // Fetch the user data
    $user = $result->fetch_assoc();

    // Verify password and start session if valid
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['id'];
        header("Location: category.php");
        exit(); // Stop the script after redirect
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Shopping Cart</title>
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
    max-width: 400px;
    margin: 100px auto; /* Center the container */
    padding: 20px;
    background: white;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #4CAF50; /* Green color */
}

.login-form {
    display: flex;
    flex-direction: column;
}

.login-form input {
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s;
}

.login-form input:focus {
    border-color: #4CAF50; /* Highlight border on focus */
}

.login-form button {
    padding: 10px;
    background-color: #4CAF50; /* Button color */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.login-form button:hover {
    background-color: #45a049; /* Darker green on hover */
}

.error-message {
    color: red; /* Error message color */
    text-align: center;
    margin: 10px 0;
}

p {
    text-align: center;
}

p a {
    color: #4CAF50;
    text-decoration: none;
}

p a:hover {
    text-decoration: underline;
}

   </style>
</head>
<body>
    <div class="container">
        <h1>Login to Your Account</h1>
        <?php if (isset($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" class="login-form">
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit" name="login">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
