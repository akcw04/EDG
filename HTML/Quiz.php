<?php
session_start();
$color_mode = isset($_SESSION['color_mode']) ? $_SESSION['color_mode'] : 0;
$css_folder = $color_mode ? "tritanopia" : "protanopia";
$font_size = isset($_SESSION['font_size']) ? $_SESSION['font_size'] : 'medium';

if (!isset($_SESSION['category_id']) || !isset($_SESSION['User_id'])) {
    header("Location: Choose_Quiz.php");
    exit;
}

include '../PHP/quiz.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
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
        <a href="../HTML/Choose_Quiz.php"><img class="logo" src="../IMG/logo.png" alt="EDG logo"></a>
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
                    <div class="button-container">
                        <form method="post">
                            <input type="hidden" name="end_quiz" value="1">
                            <button type="submit" class="end-quiz-button">End Quiz</button>
                        </form>
                        <br>
                        <form method="post">
                            <input type="hidden" name="check_quiz" value="1">
                            <button type="submit" class="answers-button">Check Answers</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
</body>
</html>
