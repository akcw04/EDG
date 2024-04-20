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
    User_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(30) NOT NULL,
    LastName VARCHAR(30) NOT NULL,
    DOB DATE,
    Gender ENUM('male', 'female', 'others'),
    PhoneNumber VARCHAR(15),
    Email VARCHAR(50) NOT NULL,
    Mode BOOLEAN,
    Password VARCHAR(255) NOT NULL,
    Role ENUM('0','1') DEFAULT '0',
    Total_attempts INT(6),
    Average_score DECIMAL(5,2),
    Best_score INT(6)
)";

$conn->query($sql_users);

// SQL to create table for questions
$sql_questions = "CREATE TABLE IF NOT EXISTS questions (
    Questions_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Category_id INT(6) UNSIGNED,
    Question_Text VARCHAR(255) NOT NULL,
    is_correct BOOLEAN,
    FOREIGN KEY (Category_id) REFERENCES category(Category_id)
)";

//SQL to create table for choices
$sql_choices = "CREATE TABLE IF NOT EXISTS choices (
    Choices_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Questions_id INT(6) UNSIGNED,
    FOREIGN KEY (Questions_id) REFERENCES questions(Questions_id)
)";


//SQL to create table for category

$sql_category = "CREATE TABLE IF NOT EXISTS category (
    Category_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Category_Name ENUM('Addition', 'Subtraction', 'Multiplication', 'Division') NOT NULL
)";


//SQL to create table for quiz

$sql_quiz = "CREATE TABLE IF NOT EXISTS quiz (
    Quiz_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    User_id INT(6) UNSIGNED,
    Category_id INT(6) UNSIGNED,
    Start_time DATETIME,
    End_time DATETIME,
    Attempts INT(0) UNSIGNED,
    Score INT(6),
    FOREIGN KEY (User_id) REFERENCES users(User_id),
    FOREIGN KEY (Category_id) REFERENCES category(Category_id)
)";


$conn->query($sql_category);
$conn->query($sql_quiz);
$conn->query($sql_questions);
$conn->query($sql_choices);


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
        echo '<script>alert("Account Created Successfully"); window.location.href = "http://localhost/EDG/HTML/Login.html";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


