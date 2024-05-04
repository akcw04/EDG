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
                <?php echo round($progress_percent); ?>%
            </div>
            <h1><?php echo $question_text; ?></h1>
            <div class="button-container">
                <?php if (!empty($questions_and_choices)): ?>
                    <?php foreach ($questions_and_choices as $choice): ?>
                        <button type="submit" class="choice" name="choice" value="<?php echo $choice['Choice_id']; ?>">
                            <p><?php echo $choice['Choice_text']; ?></p>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </form>
    </div>
</body>
</html>
