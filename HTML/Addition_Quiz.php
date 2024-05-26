<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Addition Quiz</title>
    <link rel="stylesheet" href="../CSS/Addition_Quiz.css" />
</head>
<body>
    <?php include '../PHP/addition_quiz.php'; ?>
    <div class="logo-container">
        <a href="../HTML/Choose_Quiz.html"><img class="logo" src="../IMG/logo.png" alt="EDG logo"></a>
    </div>
    <div class="form-container">
        <form action="../PHP/addition_quiz.php" method="post">
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
