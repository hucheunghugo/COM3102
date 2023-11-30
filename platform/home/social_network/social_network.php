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
$sql = "SELECT username FROM users WHERE Userid = $userid";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $username = strval($row['username']);

} else {
    echo "Error executing the query: " . $conn->error;
}

//Fetching user major
$sql = "SELECT programme FROM users WHERE Userid = $userid";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $programme = strval($row['programme']);

} else {
    echo "Error executing the query: " . $conn->error;
}




if (isset($_POST['calendar'])) {
    header("Location: ../home.php");
    exit;
} elseif (isset($_POST['grade'])) {
    header("Location: ../grade_db/grade_db.php");
    exit;
} elseif (isset($_POST['info'])) {
    header("Location: ../my_info/my_info.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WhatsApp Web</title>
  <link rel="stylesheet" href="../../style.css">
  <style>

  .upload-container {
    width: 100%;
    margin: 0 auto;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-top: 20px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    background-color: #f2f2f2;
  }

  .upload-container h2 {
    text-align: center;
    padding: 10px;
    margin: 0;
    border-radius: 5px 5px 0 0;
    width: 100%;
  }

  .upload-container img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
  }
  
  .upload-container .upload-name {
    font-weight: bold;
  }
  
  .upload-container .upload-action {
    margin-left: auto;
  }
  
  .upload-container button {
    padding: 5px 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    margin-bottom: 10px;
  }
  
  .upload-container button:hover {
    background-color: #45a049;
  }

  .upload-container form {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .upload-container form {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .upload-container form input[type="file"] {    
    margin-top: 20px;
    margin-bottom: 20px;
  }

  .upload-container form input[type="submit"] {
      background-color: #f00;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
  }

    .post-container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .post-container img {
        margin-bottom: 20px;
        border: 2px solid #f00; /* Replace #f00 with your desired color */
        padding: 10px; /* Optional: Add padding to create space between the image and the border */
    }
    
  </style>
</head>
<script>
  function redirectToLogin() {
    window.location.replace("../../");
  }
</script>
<body>

  <div class="container">
    <div class="navbar">
      <div class="navbar-left">
        <span class="username"><?php echo $username; ?></span>
      </div>
      <form action="social_network.php" method="post">
        <div class="navbar-mid">
            <button type="submit" name="calendar" class="nav-button">Calendar</button>
            <button type="submit" name="social" class="nav-button">Social Networking</button>
            <button type="submit" name ="grade" class="nav-button">Grade Database</button>
            <button type="submit" name ="info" class="nav-button">My Information</button>
        </div>
      </form>

      <div class="navbar-right">
          <button class="logout-button" onclick="redirectToLogin()">Log Out</button>
      </div>
    </div>

    <div class="friend-container">
      <h2>Friend Suggestions</h2>
      <ul>
        <?php  
        //Fetching same major as user
        $sql = "SELECT * FROM users WHERE programme = '$programme' AND username != '$username' ORDER BY RAND() LIMIT 3";
        $result = $conn->query($sql);
        $suggest_no = 0;
        if ($result) {
          if ($result->num_rows > 0) {
            // Loop through each row and retrieve the user data
            while ($row = $result->fetch_assoc()) {
              $suggest = $row['username'];                  
              $suggest_id = $row['Userid'];
              $suggest_no = $suggest_no + 1;
        ?>
            <li>
              <img src="../../img/icon.jpg">
              <span class="friend-name"><?php echo $suggest ?></span>
              <div class="friend-action">
               <form action="add_friend.php" method="post">
                <button type="submit" name="submit" value="<?php echo $suggest_id ?>">Add Friend</button>
              </form>
            </div>
        </li>
        <?php
            }
          }
        } else {
            echo "Error executing the query: " . $conn->error;
        }

        ?>
      </ul>
    </div>

    <div class="friend-container">
      <h2>Friend List</h2>
      <ul>
        <?php  
          $sql = "SELECT * FROM friend_list WHERE user_id = '$userid'";
          $result = $conn->query($sql);

          if ($result) {
              while ($row = $result->fetch_assoc()) {
                  $friend_id = $row['friend_id'];

                  $sql = "SELECT * FROM users WHERE Userid = '$friend_id'";
                  $friendResult = $conn->query($sql);

                  if ($friendResult->num_rows > 0) {
                      // Loop through each row and retrieve the user data
                      while ($friendRow = $friendResult->fetch_assoc()) {
                          $friend_name = $friendRow['username'];
                          ?>
                          <li>
                              <img src="../../img/icon.jpg">
                              <span class="friend-name"><?php echo $friend_name ?></span>
                          </li>
                          <?php
                      }
                  }
              }
          } else {
              echo "Error executing the query: " . $conn->error;
          }
        ?>
      </ul>
    </div>
    
    <div class="upload-container">
      <h2>Upload Photo</h2>
      <form action="upload/upload_photo.php" method="post" enctype="multipart/form-data">
          <input type="file" name="photo" accept="image/*">
          <button type="submit" name="submit">Upload</button>
      </form>
    </div>

    <div class="post-container">
      <h2>Posts</h2>
      <?php
        // Get all the photos from the database
        $sql = "SELECT * FROM photo";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          // Display each photo
          while($row = $result->fetch_assoc()) {
            $file_name = $row['file_name'];
            echo '<img src="upload/photo/' . $row['file_name'] . '">';
          }
        } else {
          echo 'No photos found.';
        }

        // Close the database connection
        $conn->close();
      ?>
    </div>

  </div>
</body>
</html>