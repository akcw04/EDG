<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edg";

$conn = new mysqli($servername, $username, $password, $dbname);

if(isset($_POST['submit'])) {
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $DOB = $_POST['DOB'];
    $Gender = $_POST['Gender']; // Assuming Gender is a radio button input
    $query = "INSERT INTO users (Gender) VALUES ('$Gender')";// Insert Gender into database
    $PhoneNumber = $_POST['PhoneNumber'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    
    
    // Insert user details into database
    $sql = "INSERT INTO users (FirstName, LastName, DOB, Gender, PhoneNumber, Email, Password) 
            VALUES ('$FirstName', '$LastName', '$DOB', '$Gender', '$PhoneNumber', '$Email', '$Password')";
    
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Account Created Successflly")</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

