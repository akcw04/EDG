<?php
session_start();
$color_mode = isset($_SESSION['color_mode']) ? $_SESSION['color_mode'] : 0;
$css_folder = $color_mode ? "tritanopia" : "protanopia";
$font_size = isset($_SESSION['font_size']) ? $_SESSION['font_size'] : 'medium';


// Check if category_id is set in the session
if (!isset($_SESSION['category_id'])) {
    header("Location: Choose_Quiz.php"); // Redirect if no quiz has been selected
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
$total_correct = isset($_SESSION['total_correct']) ? $_SESSION['total_correct'] : 0;
$incorrect_questions = isset($_SESSION['incorrect_questions']) ? $_SESSION['incorrect_questions'] : [];

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

// Calculate total number of questions
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
    $sql = "SELECT Is_correct FROM choices WHERE Choice_id = ?";
    $stmt_choice = $conn->prepare($sql);
    $stmt_choice->bind_param("i", $choice_id);
    $stmt_choice->execute();
    $result_choice = $stmt_choice->get_result();
    $choice = $result_choice->fetch_assoc();

    if ($choice['Is_correct']) {
        $_SESSION['total_correct']++;
    } else {
        $_SESSION['incorrect_questions'][] = $current_question_index;
    }

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
    // Calculate the percentage when all questions have been answered
    $correct_percentage = 0;
    if ($total_questions > 0) {
        $correct_percentage = ($total_correct / $total_questions) * 100;
    }
    $question_text = "End Of Quiz<br><br>You Got " . round($correct_percentage) . "% of Questions Correct!";
    $_SESSION['quiz_over'] = true;

    // Insert or update the quiz result into the database
    $userId = $_SESSION['User_id']; // Ensure you have the user_id stored in the session
    if (!isset($_SESSION['User_id'])) {
        echo '<script>alert("User ID not set in SESSION."); </script>';
        exit;
    }
    $quizId = $category_id;
    $score = $total_correct;

    $sql_insert = "INSERT INTO quiz (Quiz_id, User_id, Category_id, Score) VALUES (?, ?, ?, ?)
                   ON DUPLICATE KEY UPDATE Score = VALUES(Score)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iiii", $quizId, $userId, $category_id, $score);
    $stmt_insert->execute();
}

// Check if the end quiz action has been triggered
if (isset($_POST['action']) && $_POST['action'] == 'end_quiz') {
    // Unset specific session variables
    unset($_SESSION['quiz_over']);
    unset($_SESSION['category_id']);
    unset($_SESSION['question_index']);
    unset($_SESSION['total_correct']);
    unset($_SESSION['incorrect_questions']);

    // Redirect to the Choose Quiz page
    header("Location: ../HTML/Choose_Quiz.php");
    exit;
}

// Check if the check answers quiz action has been triggered
if (isset($_POST['action']) && $_POST['action'] == 'check_quiz') {
    // Unset specific session variables
    unset($_SESSION['quiz_over']);
    unset($_SESSION['category_id']);
    unset($_SESSION['question_index']);
    unset($_SESSION['total_correct']);
    unset($_SESSION['incorrect_questions']);

    // Redirect to the Answers page
    header("Location: ../HTML/Quiz_Answers.php");
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Addition Quiz</title>
    <link rel="stylesheet" href="../CSS/font_sizes.css">
    <link rel="stylesheet" href="../CSS/<?php echo $css_folder; ?>/Quiz.css">
    <style>
        :root {
            --font-size-base: var(--font-size-<?php echo $font_size; ?>);
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <a href="../HTML/Choose_Quiz.html"><img class="logo" src="../IMG/logo.png" alt="EDG logo"></a>
    </div>
    <div class="form-container">
        <form method="post">
            <div class="progress-container">
                <div class="progress-bar" style="width:<?php echo round($progress_percent); ?>%;">
                    <?php echo round($progress_percent); ?>%
                </div>
            </div>
            <h1><?php echo isset($question_text) ? $question_text : 'Quiz Over'; ?></h1>
            <div class="button-container">
                <?php if (!isset($_SESSION['quiz_over'])): ?>
                    <?php foreach ($questions_and_choices as $choice): ?>
                        <button type="submit" class="choice" name="choice" value="<?php echo $choice['Choice_id']; ?>">
                            <p><?php echo htmlspecialchars($choice['Choice_text']); ?></p>
                        </button>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- When quiz is over, change the form action to handle the end quiz logic -->
                    <input type="hidden" name="action" value="end_quiz">
                    <button type="submit" class="end-quiz-button">End Quiz</button>
                    <br>
                    <input type="hidden" name="action" value="check_quiz">
                    <button type="submit" class="answers-button">Check Answers</button>
                <?php endif; ?>
            </div>
        </form>
    </div>
</body>
</html>
