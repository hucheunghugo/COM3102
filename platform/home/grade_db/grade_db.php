<?php
session_start();

require '../../db_connect.php';

function sanitize($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

// Retrieve the userid from the session
$userid = $_SESSION['userid'];

//Fetching Username and SID
$sql = "SELECT username, sid FROM users WHERE Userid = $userid";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $username = strval($row['username']);
    $sid = $row['sid']; // Retrieve the sid value

} else {
    echo "Error executing the query: " . $conn->error;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

}

if (isset($_POST['calendar'])) {
    header("Location: ../home.php");
    exit;
} elseif (isset($_POST['social'])) {
    header("Location: ../social_network/social_network.php");
    exit;
} elseif (isset($_POST['info'])) {
    header("Location: ../my_info/my_info.php");
    exit;
} elseif (isset($_POST['form_submit'])) {
    // Get the form data
    $studentName = sanitize($_POST['student_name']);
    $subject = sanitize($_POST['subject']);
    $grade = $_POST['grade'];

    // Insert the grade into the database
    $sql = "INSERT INTO grades (student_name, subject, grade) VALUES ('$studentName', '$subject', '$grade')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Redirect to a different page using the GET method
        header("Location: grade_db.php");
        exit;
    } else {
        echo "Error executing the query: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Database</title>
    <link rel="stylesheet" href="../../style.css">
    <script>
        function redirectToLogin() {
            window.location.replace("../../");
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="navbar">
            <div class="navbar-left">
                <span class="username"><?php echo $username; ?></span>
            </div>
            <form action="grade_db.php" method="post">
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

        <?php if (!empty($sid)) : ?>
            <h2>Enter Grade</h2>
            <form action="grade_db.php" method="post">
                <label for="student_name">Student Name:</label>
                <input type="text" name="student_name" required><br>
                <label for="subject">Subject:</label>
                <input type="text" name="subject" required><br>
                <label for="grade">Grade:</label>
                <select name="grade" required>
                    <option value="">Select Grade</option>
                    <option value="A">A</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B">B</option>
                    <option value="B-">B-</option>
                    <option value="C+">C+</option>
                    <option value="C">C</option>
                    <option value="C-">C-</option>
                    <option value="D+">D+</option>
                    <option value="D">D</option>
                    <option value="F">F</option>
                </select><br>
                <input type="submit" name="form_submit" value="Submit">
            </form>
        <?php endif; ?>

        <h2>Filter Data by Subject</h2>
        <form action="grade_db.php" method="post">
            <label for="subject">Enter Subject:</label>
            <input type="text" name="subject" placeholder="Enter subject">
            <input type="submit" value="Filter">
        </form>

        <div class="db-container">
            <h2>Subject Statistics</h2>
            <?php
            // Check if the filter box is empty
            $filter = isset($_POST['subject']) ? $_POST['subject'] : '';

            if (!empty($filter)) {
                // Redirect to the same page with the filter value as a query parameter
                header("Location: " . $_SERVER['REQUEST_URI'] . "?subject=" . urlencode($filter));
                exit;
            }

            // Retrieve the filter value from the query parameter
            $filter = isset($_GET['subject']) ? $_GET['subject'] : '';

            if (!empty($filter)) {
                // Retrieve subject statistics from the database
                $sql = "SELECT subject,
                            SUM(CASE WHEN grade = 'A' THEN 1 ELSE 0 END) AS count_a,
                            SUM(CASE WHEN grade = 'A-' THEN 1 ELSE 0 END) AS count_a_minus,
                            SUM(CASE WHEN grade = 'B+' THEN 1 ELSE 0 END) AS count_b_plus,
                            SUM(CASE WHEN grade = 'B' THEN 1 ELSE 0 END) AS count_b,
                            SUM(CASE WHEN grade = 'B-' THEN 1 ELSE 0 END) AS count_b_minus,
                            SUM(CASE WHEN grade = 'C+' THEN 1 ELSE 0 END) AS count_c_plus,
                            SUM(CASE WHEN grade = 'C' THEN 1 ELSE 0 END) AS count_c,
                            SUM(CASE WHEN grade = 'C-' THEN 1 ELSE 0 END) AS count_c_minus,
                            SUM(CASE WHEN grade = 'D+' THEN 1 ELSE 0 END) AS count_d_plus,
                            SUM(CASE WHEN grade = 'D' THEN 1 ELSE 0 END) AS count_d,
                            SUM(CASE WHEN grade = 'F' THEN 1 ELSE 0 END) AS count_f
                            FROM grades
                            WHERE subject = '$filter'
                            GROUP BY subject";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    echo "<table>";
                    echo "<tr><th>Subject</th><th>A</th><th>A-</th><th>B+</th><th>B</th><th>B-</th><th>C+</th><th>C</th><th>C-</th><th>D+</th><th>D</th><th>F</th></tr>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['subject'] . "</td>";
                        echo "<td>" . $row['count_a'] . "</td>";
                        echo "<td>" . $row['count_a_minus'] . "</td>";
                        echo "<td>" . $row['count_b_plus'] . "</td>";
                        echo "<td>" . $row['count_b'] . "</td>";
                        echo "<td>" . $row['count_b_minus'] . "</td>";
                        echo "<td>" . $row['count_c_plus'] . "</td>";
                        echo "<td>" . $row['count_c'] . "</td>";
                        echo "<td>" . $row['count_c_minus'] . "</td>";
                        echo "<td>" . $row['count_d_plus'] . "</td>";
                        echo "<td>" . $row['count_d'] . "</td>";
                        echo "<td>" . $row['count_f'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No subject statistics found.";
                }
            } else {
                echo "Please enter a filter value.";
            }
            ?>
        </div>
    </div>
</body>

</html>
