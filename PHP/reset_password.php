<?php

session_start();

if (!isset($_SESSION['User_id'])) {
    die('User ID is not set in the session.');
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
    echo "Error: Form not submitted.";
}

session_destroy();
