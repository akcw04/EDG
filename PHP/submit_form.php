<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";

// Create connection to MySQL server
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it does not exist
$sql = "CREATE DATABASE IF NOT EXISTS edg";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully or already exists.";
} else {
    echo "Error creating database: " . $conn->error;
}

// Close the initial connection
$conn->close();

// Include the connection to the newly created database
include 'conn.php';

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
    Font_Size VARCHAR(10) DEFAULT 'medium'
)";
$conn->query($sql_users);

// SQL to create table for categories
$sql_category = "CREATE TABLE IF NOT EXISTS category (
    Category_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Category_Name VARCHAR(255) NOT NULL
)";
$conn->query($sql_category);

// SQL to create table for questions
$sql_questions = "CREATE TABLE IF NOT EXISTS questions (
    Questions_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Category_id INT(6) UNSIGNED,
    Question_Text VARCHAR(255) NOT NULL,
    FOREIGN KEY (Category_id) REFERENCES category(Category_id)
)";
$conn->query($sql_questions);

// SQL to create table for choices
$sql_choices = "CREATE TABLE IF NOT EXISTS choices (
    Choice_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Question_id INT(6) UNSIGNED,
    Choice_text VARCHAR(255) NOT NULL,
    Is_correct BOOLEAN NOT NULL,
    FOREIGN KEY (Question_id) REFERENCES questions(Questions_id)
)";
$conn->query($sql_choices);

// SQL to create table for quizzes
$sql_quiz = "CREATE TABLE IF NOT EXISTS quiz (
    Quiz_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    User_id INT(6) UNSIGNED,
    Category_id INT(6) UNSIGNED,
    Score INT(6),
    FOREIGN KEY (User_id) REFERENCES users(User_id),
    FOREIGN KEY (Category_id) REFERENCES category(Category_id),
    UNIQUE KEY (User_id, Category_id)
)";
$conn->query($sql_quiz);

// SQL to create table for user answers
$sql_answers = "CREATE TABLE IF NOT EXISTS user_answers (
    User_answer_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    User_id INT(6) UNSIGNED,
    Quiz_id INT(6) UNSIGNED,
    Question_id INT(6) UNSIGNED,
    Choice_id INT(6) UNSIGNED,
    Is_correct BOOLEAN NOT NULL,
    FOREIGN KEY (User_id) REFERENCES users(User_id),
    FOREIGN KEY (Quiz_id) REFERENCES quiz(Quiz_id),
    FOREIGN KEY (Question_id) REFERENCES questions(Questions_id),
    FOREIGN KEY (Choice_id) REFERENCES choices(Choice_id),
    UNIQUE KEY unique_user_quiz_question (User_id, Quiz_id, Question_id)
)";
$conn->query($sql_answers);



if (isset($_POST['submit'])) {
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $DOB = $_POST['DOB'];
    $Gender = $_POST['Gender']; // Assuming Gender is a radio button input
    $PhoneNumber = $_POST['PhoneNumber'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    
    // Hash the password
    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    // Insert user details into database
    $sql_insert = "INSERT INTO users (FirstName, LastName, DOB, Gender, PhoneNumber, Email, Password) 
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("sssssss", $FirstName, $LastName, $DOB, $Gender, $PhoneNumber, $Email, $hashedPassword);

    if ($stmt->execute()) {
        echo '<script>alert("Account Created Successfully"); window.location.href = "http://localhost/EDG/HTML/Login.html";</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
