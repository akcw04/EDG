<?php

$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Create database if it does not exist
$sql = "CREATE DATABASE IF NOT EXISTS edg";
$conn->query($sql);

// Establish a new connection to the created database
$conn = new mysqli($servername, $username, $password, "edg");

// SQL to create table for users
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(30) NOT NULL,
    LastName VARCHAR(30) NOT NULL,
    DOB DATE,
    Gender ENUM('male', 'female', 'others'),
    PhoneNumber VARCHAR(15),
    Email VARCHAR(50) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Role ENUM('0','1') DEFAULT '0'
)";

$conn->query($sql_users);

// SQL to create table for questions
$sql_questions = "CREATE TABLE IF NOT EXISTS questions (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Category ENUM('addition', 'subtraction', 'multiplication', 'division'),
    Question VARCHAR(255) NOT NULL,
    CorrectAnswer VARCHAR(255) NOT NULL
)";

$conn->query($sql_questions);

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
    $sql_insert = "INSERT INTO users (FirstName, LastName, DOB, Gender, PhoneNumber, Email, Password) 
    VALUES ('$FirstName', '$LastName', '$DOB', '$Gender', '$PhoneNumber', '$Email', '$Password')";
    
    if ($conn->query($sql_insert) === TRUE) {
        echo '<script>alert("Account Created Successfully"); window.location.href = "http://localhost/EDG/HTML/Signup.html";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
