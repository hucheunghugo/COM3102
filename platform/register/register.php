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
    // Retrieve the form data
    $email = sanitize($_POST['email']);
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);
    $programme = sanitize($_POST['Programme']);
    $yearOfEntrance = sanitize($_POST['Year-Of-Entrance']);
    $studentId = sanitize($_POST['SID']);
    $token = generateToken();

    // Check if the username already exists in the database
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Duplicate username found
        echo "<script>alert('Username already exists. Please choose a different one.');</script>";
    } else {
        // Check if the email already exists in the database
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Duplicate email found
            echo "<script>alert('Email already exists. Please choose a different one.');</script>";
        } else {
            // Check if the student ID is provided and if it already exists in the database
            if ($studentId !== '') {
                $sql = "SELECT * FROM users WHERE sid = '$studentId'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // Duplicate student ID found
                    echo "<script>alert('Student ID already exists. Please choose a different one.');</script>";
                } else {
                    // Insert the data into the database
                    $sql = "INSERT INTO users (email, username, password, token, programme, year_of_entrance, sid) 
                            VALUES ('$email', '$username', '$password', '$token', '$programme', '$yearOfEntrance', '$studentId')";

                    // Execute the SQL query
                    if (mysqli_query($conn, $sql)) {
                        // Registration successful
                        echo "<script>alert('Registration successful!');</script>";
                        header("Location: ../");
                        exit;
                    } else {
                        // Registration failed
                        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
                    }
                }
            } else {
                // Insert the data into the database without checking for duplicate student ID
                $sql = "INSERT INTO users (email, username, password, token, programme, year_of_entrance, sid) 
                        VALUES ('$email', '$username', '$password', '$token', NULL, NULL, NULL)";

                // Execute the SQL query
                if (mysqli_query($conn, $sql)) {
                    // Registration successful
                    echo "<script>alert('Registration successful!');</script>";
                    header("Location: ../");
                    exit;
                } else {
                    // Registration failed
                    echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
                }
            }
        }
    }

    // Close the database connection
    mysqli_close($conn);
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
