<?php
session_start();

require '../db_connect.php';

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

if (isset($_COOKIE['token'])) {
    $cookieToken = $_COOKIE['token'];
    if ($dbToken !== $cookieToken) {
        // Database token and cookie token don't match, redirect to the login page
        echo "<script>alert('Token mismatch. Please login again.');</script>";
        echo "<script>window.setTimeout(function(){ window.location.href = '../'; }, 1000);</script>";
        exit;
    }
} else {
    // Cookie token not set, redirect to the login page
    echo "<script>alert('Token mismatch. Please login again.');</script>";
    echo "<script>window.setTimeout(function(){ window.location.href = '../'; }, 1000);</script>";
    exit;
}


if (isset($_POST['social'])) {
    header("Location: social_network/social_network.php");
    exit;
} elseif (isset($_POST['grade'])) {
    header("Location: grade_db/grade_db.php");
    exit;
} elseif (isset($_POST['info'])) {
    header("Location: my_info/my_info.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Website</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="calendar.js"></script>
    <script>
        function redirectToLogin() {
            window.location.replace("../");
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <div class="navbar-left">
                <span class="username"><?php echo $username; ?></span>
            </div>
            <form action="home.php" method="post">
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
        <div class="functionality">
            <h2>Calendar</h2>
            <div class="calendar">
                <div class="calendar-header">
                    <button class="prev-btn">&lt;</button>
                    <div class="month-year"></div>
                    <button class="next-btn">&gt;</button>
                </div>  
                <table class="calendar-table">
                    <thead>
                        <tr>
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
