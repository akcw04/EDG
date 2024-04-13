<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edg";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function check_data($Email, $Password, $conn) {
    // Use prepared statements to prevent SQL Injection
    $stmt = $conn->prepare("SELECT id FROM users WHERE Email = ? AND Password = ?");
    $stmt->bind_param("ss", $Email, $Password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $_SESSION['User_id'] = $user['id']; // Store the user ID in the session
        echo '<script>alert("Login Successful"); window.location.href = "http://localhost/EDG/HTML/Pick_Color.html";</script>';
    } else {
        echo '<script>alert("No Such Account"); window.location.href = "http://localhost/EDG/HTML/Login.html";</script>';
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Email'], $_POST['Password'])) {
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    check_data($Email, $Password, $conn);
}

$conn->close();
?>
