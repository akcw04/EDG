<?php
session_start();

include 'conn.php';

if (!isset($_SESSION['User_id'])) {
    echo '<script>alert("User ID not set in SESSION."); </script>';
    exit;
}

if (isset($_POST['submit'])) {
    $Confirm_Password = $_POST['Confirm_Password'];
    
    // Hash the password
    $hashed_password = password_hash($Confirm_Password, PASSWORD_DEFAULT);
    
    $sql_update_password = "UPDATE users SET Password = ? WHERE User_id = ?";
    $stmt = $conn->prepare($sql_update_password);
    $stmt->bind_param("ss", $hashed_password, $_SESSION['User_id']);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo '<script>alert("New Password Set Successfully"); window.location.href = "http://localhost/EDG/HTML/Login.html";</script>';
        exit;
    } else {
        echo '<script>alert("Reset Password Failed"); window.location.href = "http://localhost/EDG/HTML/Reset_Password.html";</script>';
        exit;
    }
    
} else {
    echo '<script>alert("Form not submitted properly"); window.location.href = "http://localhost/EDG/HTML/Reset_Password.html";</script>';
    exit;
}
?>
