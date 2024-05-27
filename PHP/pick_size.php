<?php
session_start();

if (!isset($_SESSION['User_id'])) {
    die('User ID is not set in the session.');
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edg";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Determine the selected text size
$font_size = 'medium'; // Default size
if (isset($_POST['size1'])) {
    $font_size = 'small';
} elseif (isset($_POST['size2'])) {
    $font_size = 'medium';
} elseif (isset($_POST['size3'])) {
    $font_size = 'large';
}

// Update the user's text size preference in the database
$sql_update = "UPDATE users SET Font_Size = ? WHERE User_id = ?";
$stmt = $conn->prepare($sql_update);

if ($stmt) {
    $stmt->bind_param("si", $font_size, $_SESSION['User_id']);
    $stmt->execute();
    $_SESSION['font_size'] = $font_size; // Update the session variable
    $stmt->close();
    echo '<script>alert("Text size updated to ' . $font_size . '"); window.location.href = "../HTML/User_Dashboard.php";</script>';
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>
