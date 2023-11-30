<?php

session_start();

require '../../db_connect.php';

function sanitize($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

// Retrieve the userid from the session
$userid = $_SESSION['userid'];


// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Get the value of the button
    $buttonValue = $_POST['submit'];

    
    $sql = "INSERT INTO friend_list(user_id, friend_id)
    VALUES ('$userid', $buttonValue)";
    $result = mysqli_query($conn, $sql);

    $sql = "INSERT INTO friend_list(user_id, friend_id)
    VALUES ('$buttonValue', $userid)";
    $result = mysqli_query($conn, $sql);

    // Use the button value in your code
    echo "<script>alert('You have added a new friend');</script>";
        echo "<script>window.setTimeout(function(){ window.location.href = 'social_network.php'; }, 1000);</script>";
} else {
    // The form is not submitted
    echo "Form not submitted";
}
?>
