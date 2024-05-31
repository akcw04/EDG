<?php
include 'conn.php';

$category_id = $_SESSION['category_id'];
$current_question_index = isset($_SESSION['question_index']) ? $_SESSION['question_index'] : 0;
$total_correct = isset($_SESSION['total_correct']) ? $_SESSION['total_correct'] : 0;
$incorrect_questions = isset($_SESSION['incorrect_questions']) ? $_SESSION['incorrect_questions'] : [];

// Initialize a new quiz session in the database or update existing one
if ($current_question_index === 0) {
    $sql_insert_quiz = "INSERT INTO quiz (User_id, Category_id, Score) VALUES (?, ?, 0)
                        ON DUPLICATE KEY UPDATE Quiz_id = LAST_INSERT_ID(Quiz_id)";
    $stmt_insert_quiz = $conn->prepare($sql_insert_quiz);
    $stmt_insert_quiz->bind_param("ii", $_SESSION['User_id'], $category_id);
    if ($stmt_insert_quiz->execute()) {
        $quiz_id = $conn->insert_id; // Retrieve the new or existing quiz ID
        $_SESSION['current_quiz_id'] = $quiz_id;
    } else {
        die("Error creating or updating quiz entry: " . $stmt_insert_quiz->error);
    }
} else {
    $quiz_id = $_SESSION['current_quiz_id']; // Use the existing quiz ID from the session
}

$sql = "SELECT q.Question_Text, c.Choice_text, c.Is_correct, c.Choice_id, q.Questions_id
        FROM questions q
        JOIN choices c ON q.Questions_id = c.Question_id
        WHERE q.Category_id = ? AND q.Questions_id = (
            SELECT Questions_id FROM questions WHERE Category_id = ? ORDER BY Questions_id ASC LIMIT 1 OFFSET ?
        )";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $category_id, $category_id, $current_question_index);
$stmt->execute();
$result = $stmt->get_result();

$sql_count = "SELECT COUNT(*) as total FROM questions WHERE Category_id = ?";
$stmt_count = $conn->prepare($sql_count);
$stmt_count->bind_param("i", $category_id);
$stmt_count->execute();
$result_count = $stmt_count->get_result();
$row_count = $result_count->fetch_assoc();
$total_questions = $row_count['total'];
$progress_percent = ($current_question_index / $total_questions) * 100;

if (isset($_POST['choice'])) {
    $choice_id = $_POST['choice'];
    $sql = "SELECT Is_correct, Question_id FROM choices WHERE Choice_id = ?";
    $stmt_choice = $conn->prepare($sql);
    $stmt_choice->bind_param("i", $choice_id);
    $stmt_choice->execute();
    $result_choice = $stmt_choice->get_result();
    $choice = $result_choice->fetch_assoc();

    $is_correct = $choice['Is_correct'];
    if ($is_correct) {
        $_SESSION['total_correct']++;
    } else {
        $_SESSION['incorrect_questions'][] = $current_question_index;
    }

    // Insert each answer's correctness into the database
    $sql_insert_answer = "INSERT INTO user_answers (User_id, Quiz_id, Question_id, Choice_id, Is_correct)
                          VALUES (?, ?, ?, ?, ?)";
    $stmt_insert_answer = $conn->prepare($sql_insert_answer);
    $stmt_insert_answer->bind_param("iiiii", $_SESSION['User_id'], $quiz_id, $choice['Question_id'], $choice_id, $is_correct);
    $stmt_insert_answer->execute();

    $_SESSION['question_index']++;

    header("Location: ../HTML/Quiz.php");
    exit;
}


if ($result->num_rows > 0) {
    $questions_and_choices = [];
    while ($row = $result->fetch_assoc()) {
        $questions_and_choices[] = $row;
    }
    shuffle($questions_and_choices);
    $question_text = $questions_and_choices[0]['Question_Text'];
} else {
    $correct_percentage = 0;
    if ($total_questions > 0) {
        $correct_percentage = ($total_correct / $total_questions) * 100;
    }
    $question_text = "End Of Quiz<br><br>You Got " . round($correct_percentage) . "% of Questions Correct!";
    $_SESSION['quiz_over'] = true;
}

if (isset($_POST['action1']) && $_POST['action1'] == 'end_quiz') {
    unset($_SESSION['quiz_over']);
    unset($_SESSION['category_id']);
    unset($_SESSION['question_index']);
    unset($_SESSION['total_correct']);
    unset($_SESSION['incorrect_questions']);

    header("Location: ../HTML/Choose_Quiz.php");
    exit;
}

if (isset($_POST['action2']) && $_POST['action2'] == 'check_quiz') {
    unset($_SESSION['quiz_over']);
    unset($_SESSION['category_id']);
    unset($_SESSION['question_index']);
    unset($_SESSION['total_correct']);
    unset($_SESSION['incorrect_questions']);

    header("Location: ../HTML/Quiz_Answers.php");
    exit;
}

$conn->close();
?>
