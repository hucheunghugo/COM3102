<?php
require '../db_connect.php';

// Function to sanitize user inputs
function sanitize($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
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
                    $sql = "INSERT INTO users (email, username, password, programme, year_of_entrance, sid) 
                            VALUES ('$email', '$username', '$password', '$programme', '$yearOfEntrance', '$studentId')";

                    // Execute the SQL query
                    if (mysqli_query($conn, $sql)) {
                        // Registration successful
                        echo "<script>alert('Registration successful!');</script>";
                        header("Location: ../login/login.php");
                        exit;
                    } else {
                        // Registration failed
                        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
                    }
                }
            } else {
                // Insert the data into the database without checking for duplicate student ID
                $sql = "INSERT INTO users (email, username, password, programme, year_of_entrance, sid) 
                        VALUES ('$email', '$username', '$password', NULL, NULL, NULL)";

                // Execute the SQL query
                if (mysqli_query($conn, $sql)) {
                    // Registration successful
                    echo "<script>alert('Registration successful!');</script>";
                    header("Location: ../login/login.php");
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
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Moodle Registration</title>
    <link rel="stylesheet" type="text/css" href="../index.css">
    <script>
        function redirectToLogin() {
            window.location.replace("../");
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Moodle Registration</h2>
        <form action="register.php" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="Programme" placeholder="Programme ( If u are HSU Student )" >
            <input type="text" name="Year-Of-Entrance" placeholder="Year Of Entrance ( If u are HSU Student )" >
            <input type="text" name="SID" placeholder="Student ID ( If u are HSU Student )" >
            <input type="submit" value="Register">
            <input type="button" onclick="redirectToLogin()" value="Go back to Login">
        </form>
    </div>
</body>
</html>
