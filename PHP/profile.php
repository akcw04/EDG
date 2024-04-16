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

$user_id = $_SESSION['User_id'];

// Query to fetch user data
$sql = "SELECT FirstName, LastName, DOB, Gender, PhoneNumber, Email, Password FROM users WHERE User_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('MySQL prepare error: ' . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($userData = $result->fetch_assoc()) {
    // Data fetched successfully
    // You can now use $userData array to access user details
    echo "User Found: " . $userData['FirstName'];
} else {
    echo "No user found with ID: $user_id";
}


