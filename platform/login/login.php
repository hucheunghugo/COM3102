<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Perform login logic here
    // ...
    
    // Redirect to the home page after successful login
    header("Location: ../home/home.html");
    exit;
}
?>