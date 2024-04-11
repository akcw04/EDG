<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edg";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed. " . $conn->connect_error);
}
echo '<script>alert("database Connected")</script>';

