<?php
session_start();

include 'conn.php';


$timeout_duration = 60; // Timeout duration in seconds

// Check if session has expired or if the timeout flag is set
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout_duration)) {
    $_SESSION['TIMEOUT_OCCURRED'] = true; // Set a flag indicating a timeout has occurred
    echo '<script>alert("You have exceeded the time limit. Please Reverify the Email Account.");</script>';
    echo '<script>window.location.href = "http://localhost/EDG/HTML/Forgot_Password.html";</script>';
    exit;
}

if (isset($_SESSION['TIMEOUT_OCCURRED']) && $_SESSION['TIMEOUT_OCCURRED']) {
    echo '<script>alert("Session still timed out. Please Reverify Your Account");</script>';
    exit;  // Prevent access to the page functionality
}

$_SESSION['LAST_ACTIVITY'] = time(); // Update last activity time stamp

if (!isset($_SESSION['User_id'])) {
    echo '<script>alert("User ID not set in SESSION."); </script>';
    exit;
}

if (isset($_POST['submit'])) {
    $Confirm_Password = $_POST['Confirm_Password'];
    $sql_update_password = "UPDATE users SET Password = ? WHERE User_id = ?";
    $stmt = $conn->prepare($sql_update_password);
    $stmt->bind_param("ss", $Confirm_Password, $_SESSION['User_id']);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo '<script>alert("New Password Set Successfully"); window.location.href = "http://localhost/EDG/HTML/Login.html";</script>';
        exit;
    } else {
        echo '<script>alert("Reset Password Failed"); window.location.href = "http://localhost/EDG/HTML/Reset_Password.html";</script>';
        exit;
    }
    
} else {
    echo '<script>alert("Something Went Wrong"); window.location.href = "http://localhost/EDG/HTML/Reset_Password.html";</script>';
    exit;
}
?>
