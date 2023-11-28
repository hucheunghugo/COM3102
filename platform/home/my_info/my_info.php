<?php
session_start();

require '../../db_connect.php';

// Retrieve the userid from the session
$userid = $_SESSION['userid'];

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Information</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .info-container {
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .info-container h2 {
            text-align: center;
        }

        .info-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-container table th,
        .info-container table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .info-container table th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="new-container">
        <div class="navbar">
            <div class="navbar-left">
                <span class="username"><?php echo $username; ?></span>
            </div>
            <form action="social_network.php" method="post">
                <div class="navbar-mid">
                    <button type="submit" name="calendar" class="nav-button">Calendar</button>
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
        </div>
    </div>

    <script>
        function redirectToLogin() {
            window.location.replace("../../");
        }
    </script>
</body>
</html>
