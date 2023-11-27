<?php
require '../db_connect.php';

// Function to sanitize user inputs
function sanitize($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

// Function to generate a random token
function generateToken() {
    return bin2hex(random_bytes(16)); // Generate a 32-character random token
}

// Check if the token is valid
function validateToken($token) {
    global $conn;
    $token = sanitize($token);
    $sql = "SELECT * FROM users WHERE token = '$token'";
    $result = mysqli_query($conn, $sql);
    return ($result && mysqli_num_rows($result) > 0);
}

// Check if the token is present in the request headers
function getTokenFromHeaders() {
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'];
        $token = str_replace('Bearer ', '', $authorizationHeader);
        return $token;
    }
    return null;
}

// Check if the token is valid for the current request
function authenticateRequest() {
    $token = getTokenFromHeaders();
    
    // Validate the token
    if ($token && validateToken($token)) {
        return true;
    } else {
        return false;
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the username and password from the form
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    // Query the database to check if the user exists and the password is correct
    $sql = "SELECT * FROM users WHERE BINARY username = '$username' AND BINARY password = '$password'";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful and if a matching user was found
    if ($result && mysqli_num_rows($result) > 0) {
        // User exists, generate a token
        $token = generateToken();

        // Update the user's token in the database
        $sql = "UPDATE users SET token = '$token' WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        // Set the token as a cookie
        setcookie('token', $token, time() + 3600, '/'); // Expires in 1 hour

        // Redirect to the home page or do any other necessary actions
        header('Location: ../home/home.html');
        exit();
    } else {
        // Invalid credentials, display an error message
        echo 'Invalid username or password';
    }
} else {
    // Check if the token is valid for the current request
    if (!authenticateRequest()) {
        // Token is invalid or missing, return an error response
        http_response_code(401);
        echo 'Unauthorized';
        exit();
    }
}
?>
