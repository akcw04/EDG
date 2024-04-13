<?php
session_start();

if (!isset($_SESSION['User_id'])) {
    // Redirect if the user is not logged in
    echo '<script>window.location.href = "http://localhost/EDG/HTML/Login.html";</script>';
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edg";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$mode = isset($_POST['mode2']) ? 1 : 0; // Simplified mode check
$sql_update = "UPDATE users SET Mode = ? WHERE id=?";
$stmt = $conn->prepare($sql_update);

if ($stmt) {
    $stmt->bind_param("ii", $mode, $_SESSION['User_id']);
    $stmt->execute();
    $mode_selected = $mode ? "Mode 2 Selected" : "Mode 1 Selected";
    $redirect_page = $mode ? "User_Dashboard2.html" : "User_Dashboard.html";
    $stmt->close();
    echo '<script>alert("'.$mode_selected.'"); window.location.href = "http://localhost/EDG/HTML/'.$redirect_page.'";</script>';
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();

