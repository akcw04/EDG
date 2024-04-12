<?php

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

// Assuming the 'mode1' and 'mode2' are from a form indicating user preferences
$Mode1 = $_POST['mode1'] ?? null; // Using null coalescing operator to handle undefined indexes
$Mode2 = $_POST['mode2'] ?? null;

// Update Mode based on POST data
if (isset($Mode2)) {
    $sql_update = "UPDATE users SET Mode=1 WHERE id=?";
    $mode_selected = "Mode 2 Selected";
    $redirect_page = "User_Dashboard.html";
} else {
    $sql_update = "UPDATE users SET Mode=0 WHERE id=?";
    $mode_selected = "Mode 1 Selected";
    $redirect_page = "User_Dashboard2.html";
}

$stmt = $conn->prepare($sql_update);
if ($stmt) {
    $stmt->bind_param("i", $_SESSION['userId']);
    $stmt->execute();
    $stmt->close();
    echo '<script>alert("'.$mode_selected.'"); window.location.href = "http://localhost/EDG/HTML/'.$redirect_page.'";</script>';
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "edg";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);


// $Mode1 = $_POST['mode1'];
// $Mode2 = $_POST['mode2'];

// if (isset($_POST['mode2'])) {
//     $sql_mode1 = 'UPDATE users (Mode) VALUES to 0';
//     echo '<script>alert("Mode 2 Selected"); window.location.href = "http://localhost/EDG/HTML/User_Dashboard.html";</script>';
//     $conn->query($sql_mode2);
// } else {
//     $sql_mode2 = 'UPDATE users (Mode) VALUES to 1';
//     echo '<script>alert("Mode 1 Selected"); window.location.href = "http://localhost/EDG/HTML/User_Dashboard2.html";</script>';
//     $conn->query($sql_mode1);
// }

  
