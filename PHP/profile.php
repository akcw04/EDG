<?php
session_start();

// Check if User_id is set in the session before doing anything else
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

// Query to fetch user data
$sql = "SELECT FirstName, LastName, DOB, Gender, PhoneNumber, Email, Password FROM users WHERE User_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die('MySQL prepare error: ' . $conn->error);
}

// Bind the user ID from session
$stmt->bind_param("i", $_SESSION['User_id']);
$stmt->execute();

// Fetch results
$result = $stmt->get_result(); // Get the result set from the prepared statement

if ($userData = $result->fetch_assoc()) {

} else {
    echo "No user found with that ID.";
}

$stmt->close();
$conn->close();

