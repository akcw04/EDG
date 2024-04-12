<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edg";


$conn = new mysqli($servername, $username, $password, $dbname);

function check_data($Email, $Password, $conn) {

    $sql = "SELECT * FROM users WHERE Email = '$Email' AND Password = '$Password'";
    $result = $conn->query($sql);

    if ($result->num_rows >= 1) {
        echo '<script>alert("Login Successful"); window.location.href = "http://localhost/EDG/HTML/Pick_Color.html";</script>';
  
    } else {
        echo '<script>alert("No Such Account"); window.location.href = "http://localhost/EDG/HTML/Login.html";</script>';
    }

}

$Email = $_POST['Email'];
$Password = $_POST['Password'];

check_data($Email, $Password, $conn);

