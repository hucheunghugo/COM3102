<?php
if (isset($_POST['social'])) {
    header("Location: social_network/social_network.html");
    exit;
} elseif (isset($_POST['grade'])) {
    // Grade Database button was clicked
    // Add your code here for handling the Grade Database button action
} elseif (isset($_POST['info'])) {
    // My Information button was clicked
    // Add your code here for handling the My Information button action
}

?>