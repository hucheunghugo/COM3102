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
$sql = "SELECT username, token FROM users WHERE Userid = $userid";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $username = strval($row['username']);
    $dbToken = $row['token'];
} else {
    echo "Error executing the query: " . $conn->error;
}

// Check if the database token and the cookie token match
if (isset($_COOKIE['token'])) {
    $cookieToken = $_COOKIE['token'];

    // Fetching User Information
    $sql = "SELECT * FROM users WHERE Userid = $userid";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $password = $row['password'];
        $email = $row['email'];
        $programme = $row['programme'];
        $year_of_entrance = $row['year_of_entrance'];
        $sid = $row['sid'];
    } else {
        echo "Error executing the query: " . $conn->error;
    }

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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sql = "SELECT username, token FROM users WHERE Userid = $userid";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $username = strval($row['username']);
        $dbToken = $row['token'];
    } else {
        echo "Error executing the query: " . $conn->error;
    }

    // Check if the database token and the cookie token match
    if (isset($_COOKIE['token'])) {
        $cookieToken = $_COOKIE['token'];

        // Fetching User Information
        $sql = "SELECT * FROM users WHERE Userid = $userid";
        $result = $conn->query($sql);


        $newUsername = $_POST['username'];
        $newPassword = $_POST['password'];
        $newEmail = $_POST['email'];
        $newProgramme = $_POST['programme'];
        $newYearOfEntrance = $_POST['year_of_entrance'];
        $newSID = $_POST['sid'];
    
        // Update User Information
        $updateSql = "UPDATE users SET username = '$newUsername', password = '$password', email = '$newEmail'";
    
        // Check if the user has SID
        if (!empty($sid)) {
            $updateSql .= ", programme = '$newProgramme', year_of_entrance = '$newYearOfEntrance'";
        }
    
        // Check if SID is provided
        if (!empty($newSID)) {
            $updateSql .= ", sid = '$newSID'";
        }
    
        $updateSql .= " WHERE Userid = $userid";
        $updateResult = $conn->query($updateSql);
    
        if ($updateResult) {
            // Redirect to My Information page after successful update
            header("Location: my_info.php");
            exit;
        } else {
            echo "Error updating user information: " . $conn->error;
        }

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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Information</title>
    <link rel="stylesheet" href="../../style.css">
    <style>

    </style>
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
        <div class="edit-container">
            <h2>Edit Information</h2>
            <form action="edit_info.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo $password; ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

                <?php if (!empty($sid)) { ?>
                    <label for="programme">Programme:</label>
                    <input type="text" id="programme" name="programme" value="<?php echo $programme; ?>">

                    <label for="year_of_entrance">Year of Entrance:</label>
                    <input type="number" id="year_of_entrance" name="year_of_entrance" value="<?php echo $year_of_entrance; ?>">
                <?php } ?>

                <?php if (!empty($sid) || !empty($programme) || !empty($year_of_entrance)) { ?>
                    <label for="sid">SID:</label>
                    <input type="text" id="sid" name="sid" value="<?php echo $sid; ?>">
                <?php } ?>

                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        function redirectToLogin() {
            window.location.replace("../../");
        }
    </script>
</body>
</html>
