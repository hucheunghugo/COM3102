<?php
session_start();

require '../../db_connect.php';

function sanitize($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

// Retrieve the userid from the session
$userid = $_SESSION['userid'];

//Fetching Username
$sql = "SELECT username, token, sid FROM users WHERE Userid = $userid";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $username = strval($row['username']);
    $dbToken = $row['token'];
    $sid = $row['sid'];
} else {
    echo "Error executing the query: " . $conn->error;
}

// Check if the database token and the cookie token match
if (isset($_COOKIE['token'])) {

        // Fetching User Information
    $sql = "SELECT * FROM users WHERE Userid = $userid";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $email = $row['email'];
        $programme = $row['programme'];
        $year_of_entrance = $row['year_of_entrance'];
        $sid = $row['sid'];
    } else {
        echo "Error executing the query: " . $conn->error;
    }

    $cookieToken = $_COOKIE['token'];
    if ($dbToken !== $cookieToken) {
        // Database token and cookie token don't match, redirect to the login page
        echo "<script>alert('Token mismatch. Please login again.');</script>";
        echo "<script>window.setTimeout(function(){ window.location.href = '../../'; }, 1000);</script>";
        exit;
    }
} else {
    // Cookie token not set, redirect to the login page
    echo "<script>alert('Token mismatch. Please login again.');</script>";
    echo "<script>window.setTimeout(function(){ window.location.href = '../../'; }, 1000);</script>";
    exit;
}



if (isset($_POST['calendar'])) {
    header("Location: ../home.php");
    exit;
} elseif (isset($_POST['social'])) {
    header("Location: ../social_network/social_network.php");
    exit;
} elseif (isset($_POST['grade'])) {
    header("Location: ../grade_db/grade_db.php");
    exit;
} elseif (isset($_POST['edit'])) {
    header("Location: edit_info.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Information</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <div class="container">
        <div class="navbar">
            <div class="navbar-left">
                <span class="username"><?php echo $username; ?></span>
            </div>
            <form action="my_info.php" method="post">
                <div class="navbar-mid">
                    <button type="submit" name="calendar" class="nav-button">Calendar</button>
                    <?php if (!empty($sid)) { ?>
                       <button type="submit" name="social" class="nav-button">Social Networking</button>
                    <?php } ?>
                    <button type="submit" name="grade" class="nav-button">Grade Database</button>
                    <button type="submit" name="info" class="nav-button">My Information</button>
                </div>
            </form>
            <div class="navbar-right">
                <button class="logout-button" onclick="redirectToLogin()">Log Out</button>
            </div>
        </div>
        <div class="info-container">
            <h2>My Information</h2>
            <table>
                <tr>
                    <th>Username</th>
                    <td><?php echo $username; ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo $email; ?></td>
                </tr>
                <?php if (!empty($programme)) { ?>
                    <tr>
                        <th>Programme</th>
                        <td><?php echo $programme; ?></td>
                    </tr>
                <?php } ?>
                <?php if (!empty($year_of_entrance)) { ?>
                    <tr>
                        <th>Year of Entrance</th>
                        <td><?php echo $year_of_entrance; ?></td>
                    </tr>
                <?php } ?>
                <?php if (!empty($sid)) { ?>
                    <tr>
                        <th>SID</th>
                        <td><?php echo $sid; ?></td>
                    </tr>
                <?php } ?>
            </table>
            <button class="edit-button" onclick="redirectToEdit()">Edit</button>
        </div>
    </div>

    <script>
        function redirectToLogin() {
            window.location.replace("../../");
        }
        
        function redirectToEdit() {
            window.location.replace("edit_info.php");
        }
    </script>
</body>
</html>
