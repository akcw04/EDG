<?php
session_start();

include 'conn.php';

function check_data($Email, $Password, $conn) {
    // Use prepared statements to prevent SQL Injection
    $stmt = $conn->prepare("SELECT User_id, Role FROM users WHERE Email = ? AND Password = ?");
    $stmt->bind_param("ss", $Email, $Password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $_SESSION['User_id'] = $user['User_id']; // Store the user ID in the session
        $_SESSION['Role'] = $user['Role']; // Store the Role in the session
        echo '<script>alert("Login Successful"); window.location.href = "http://localhost/EDG/HTML/Pick_Color.html";</script>';
    } else {
        echo '<script>alert("No Such Account"); window.location.href = "http://localhost/EDG/HTML/Login.html";</script>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Email'], $_POST['Password'])) {
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    check_data($Email, $Password, $conn);
}
?>
