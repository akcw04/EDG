<?php
session_start();

if (!isset($_SESSION['User_id'])) {
    echo "no user id found in session";
    exit;
}

include '../PHP/conn.php';


$mode = isset($_POST['mode2']) ? 1 : 0; // Simplified mode check
$_SESSION['color_mode'] = $mode; // Store the selected mode in the session

$sql_update = "UPDATE users SET Mode = ? WHERE User_id=?";
$stmt = $conn->prepare($sql_update);

if ($stmt) {
    $stmt->bind_param("ii", $mode, $_SESSION['User_id']);
    $stmt->execute();
    $mode_selected = $mode ? "Mode 2 Selected" : "Mode 1 Selected";
    $stmt->close();
    echo '<script>alert("'.$mode_selected.'"); window.location.href = "http://localhost/EDG/HTML/Pick_Size.html";</script>';
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>
