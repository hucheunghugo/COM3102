<?php
session_start();

require '../../../db_connect.php';

function sanitize($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

// Retrieve the userid from the session
$userid = $_SESSION['userid'];

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Database connection
    include('../../../db_connect.php');
    
    // File upload path
    $targetDir = "photo/";
    $fileName = basename($_FILES["photo"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
    // Allow certain file formats
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
    if(in_array($fileType, $allowedTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)){
            // Store the photo details in the database
            $sql = "INSERT photo SET file_name = '$fileName'";
            $result = $conn->query($sql);
            if($result){
                echo "<script>alert('Photo Uploaded.');</script>";
                echo "<script>window.setTimeout(function(){ window.location.href = '../social_network.php'; }, 1000);</script>";
                exit;
            } else{
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else{
            echo "Error uploading file.";
        }
    } else{
        echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
    }
}
?>
