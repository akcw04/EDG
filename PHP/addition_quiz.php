<?php
session_start();

// Check if category_id is set in the session
if (!isset($_SESSION['category_id'])) {
    header("Location: Choose_Quiz.html"); // Redirect if no quiz has been selected
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edg";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$category_id = $_SESSION['category_id'];
$current_question_index = isset($_SESSION['question_index']) ? $_SESSION['question_index'] : 0;

// Fetch the current question and all choices from the database
$sql = "SELECT q.Question_Text, c.Choice_text, c.Is_correct, c.Choice_id
        FROM questions q
        JOIN choices c ON q.Questions_id = c.Question_id
        WHERE q.Category_id = ? AND q.Questions_id = (
            SELECT Questions_id FROM questions WHERE Category_id = ? ORDER BY Questions_id ASC LIMIT 1 OFFSET ?
        )";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $category_id, $category_id, $current_question_index);
$stmt->execute();
$result = $stmt->get_result();

// Assuming $category_id is already defined and set in your session or passed directly
$sql_count = "SELECT COUNT(*) as total FROM questions WHERE Category_id = ?";
$stmt = $conn->prepare($sql_count);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result_count = $stmt->get_result();
$row_count = $result_count->fetch_assoc();
$total_questions = $row_count['total'];

if ($total_questions > 0) { // Ensure there is at least one question to avoid division by zero
    $progress_percent = ($current_question_index / $total_questions) * 100;
} else {
    $progress_percent = 0; // Handle cases where there are no questions
}

if (isset($_POST['choice'])) {
    // Assume choice_id is submitted as part of the form
    $choice_id = $_POST['choice'];

    // Check if the choice was correct (optional, depends on your requirements)
    $sql = "SELECT Is_correct FROM choices WHERE Choice_id = $choice_id";
    $result = $conn->query($sql);
    $choice = $result->fetch_assoc();

    // Increment question index to move to the next question
    $_SESSION['question_index']++;

    // Optionally, check if the choice was correct
    if ($choice['Is_correct']) {
        // Handle correct answer logic
    }

    // Redirect back to the quiz page to display the next question
    header("Location: ../HTML/Addition_Quiz.php");
    exit;

}

if ($result->num_rows > 0) {
    $questions_and_choices = [];
    while ($row = $result->fetch_assoc()) {
        $questions_and_choices[] = $row;
    }
    // Shuffle the choices array to randomize the order of choices
    shuffle($questions_and_choices);
    $question_text = $questions_and_choices[0]['Question_Text']; // Assume all choices have the same question text
} else {
    $question_text = "End of Quiz";
    // Clear quiz-specific session variables
    unset($_SESSION['category_id']);
    unset($_SESSION['question_index']);
    exit;  // Exit script to avoid further processing
}




