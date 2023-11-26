<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data

    // Perform login logic here
    // ...
    
    // Redirect to the home page after successful login
    header("Location: ../");
    exit;
}
?>