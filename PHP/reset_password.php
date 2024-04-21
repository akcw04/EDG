<?php

session_start();

$timeout_duration = 600;

// Check if the timeout field exists
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout_duration)) {
    // Last request was more than 10 minutes ago
    session_unset();     // unset $_SESSION variable
    session_destroy();   // destroy session data
    die('<script>alert("Session Timed OUT, Please RETRY")</script>');
}

// Update LAST_ACTIVITY time stamp
$_SESSION['LAST_ACTIVITY'] = time();

if (!isset($_SESSION['User_id'])) {
    die('<script>alert("User ID not set in SESSION")</script>');
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edg";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    // Get the new password from the form
    $Confirm_Password = $_POST['Password'];

    // Prepare the SQL statement
    $sql_update_password = "UPDATE users SET Password = ? WHERE User_id = ?";
    $stmt = $conn->prepare($sql_update_password);

    // Bind parameters
    $stmt->bind_param("ss", $Confirm_Password, $_SESSION['User_id']);

    // Execute the statement
    $stmt->execute();

    // Check if the password was updated successfully
    $change_successfully = $stmt->affected_rows > 0 ? "New Password Set Successfully" : "Password failed to change";

    // Close the statement
    $stmt->close();

    // Redirect with message
    $redirect_page = $change_successfully == "New Password Set Successfully" ? "login.html" : "Reset_Password.html";
    echo '<script>alert("' . $change_successfully . '"); window.location.href = "http://localhost/EDG/HTML/' . $redirect_page . '";</script>';
    } else {
        echo '<script>alert("Error Resetting Password, Please Try Again")</script>';
        false;
    }

session_destroy();
