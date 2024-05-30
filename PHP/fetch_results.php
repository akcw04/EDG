<?php
include '../PHP/conn.php';
// session_start();

if (!isset($_SESSION['User_id'])) {
    die('User ID is not set in the session.');
}

$user_id = $_SESSION['User_id'];
$filter_category_id = $_GET['category'] ?? 'all';
$category_filter = $filter_category_id !== 'all' ? "AND q.Category_id = '$filter_category_id'" : '';

$sql = "SELECT q.Quiz_id, q.Score, 
               (SELECT COUNT(*) FROM questions WHERE Category_id=q.Category_id) as total_questions, 
               (SELECT COUNT(*) FROM user_answers ua WHERE ua.Quiz_id=q.Quiz_id AND ua.Is_correct=1) as correct_answers 
        FROM quiz q 
        WHERE q.User_id = $user_id $category_filter 
        ORDER BY q.Quiz_id DESC";
$result = $conn->query($sql);

$quiz_results = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $percentage = ($row['correct_answers'] / $row['total_questions']) * 100;
        $quiz_results[] = [
            'Quiz_id' => $row['Quiz_id'],
            'Score' => $row['Score'],
            'correct_answers' => $row['correct_answers'],
            'total_questions' => $row['total_questions'],
            'percentage' => round($percentage, 2)
        ];
    }
}

$conn->close();
?>
