<?php
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded username and password
    $default_username = "admin"; 
    $default_password = "admin123";

    // Check if entered credentials match the hardcoded ones
    if ($username === $default_username && $password === $default_password) {
        $_SESSION['admin'] = $username; // Store admin session
        header("Location: dashboard.php"); // Redirect to admin dashboard
        exit();
    } else {
        // Invalid login message
        $error_message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
    margin: 100px auto; /* Center the container vertically */
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

.login-form {
    display: flex;
    flex-direction: column;
}

.login-form label {
    margin-bottom: 5px;
    font-weight: bold;
}

.login-form input[type="text"],
.login-form input[type="password"] {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.login-form button {
    padding: 10px;
    background-color: #4CAF50; /* Button color */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 16px;
}

.login-form button:hover {
    background-color: #45a049; /* Darker green on hover */
}

.error-message {
    color: red;
    text-align: center;
    margin-top: 10px;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Login</h1>
        <form method="POST" action="login.php" class="login-form">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit" name="login">Login</button>
            <?php if (isset($error_message)): ?>
                <p class="error-message"><?= $error_message; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
