<?php
$mysqli = new mysqli("localhost", "root", "", "shoppingcart");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // reCAPTCHA validation
    $recaptcha_secret = '6LdwdGcqAAAAAK42y_rweJ8Rs5fmRCcZi3oonEaM';  // Replace with your secret key
    $recaptcha_response = $_POST['g-recaptcha-response'];
    
    // Verify reCAPTCHA response
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response
    );

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $result_json = json_decode($result);
    
    // Check if reCAPTCHA is successful
    if ($result_json->success) {
        // Continue with registration
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
       
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password);
        
        if ($stmt->execute()) {
            echo "<div class='success-message'>User registered successfully!</div>";
        } else {
            echo "<div class='error-message'>Error: " . $mysqli->error . "</div>";
        }
    } else {
        echo "<div class='error-message'>Please complete the CAPTCHA.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

h2 {
    text-align: center;
    color: #4CAF50; /* Green color */
}

form {
    display: flex;
    flex-direction: column;
}

form label {
    margin-top: 10px;
    margin-bottom: 5px;
}

form input {
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s;
}

form input:focus {
    border-color: #4CAF50; /* Highlight border on focus */
}

form button {
    padding: 10px;
    background-color: #4CAF50; /* Button color */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

form button:hover {
    background-color: #45a049; /* Darker green on hover */
}

.login-button {
    background-color: #008CBA; /* Blue color */
    margin-top: 10px;
}

.login-button:hover {
    background-color: #007BB5; /* Darker blue on hover */
}

.error-message {
    color: red; /* Error message color */
    text-align: center;
}

.success-message {
    color: green; /* Success message color */
    text-align: center;
}

.g-recaptcha {
    margin: 20px 0; /* Space between the reCAPTCHA and the buttons */
}

   </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<div class="container">
    <h2>Create an Account</h2>
    <form action="register.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <!-- Add reCAPTCHA widget here -->
        <div class="g-recaptcha" data-sitekey="6LdwdGcqAAAAACu7CZ8lYbiB4fZQcRLM56T67lc0"></div>

        <button type="submit">Register</button>
        <!-- Adding Login Button -->
        <a href="login.php">
            <button type="button" class="login-button">Login</button>
        </a>
    </form>
</div>

</body>
</html>
