<?php
session_start();
$color_mode = isset($_SESSION['color_mode']) ? $_SESSION['color_mode'] : 0;
$css_folder = $color_mode ? "tritanopia" : "protanopia";
$font_size = isset($_SESSION['font_size']) ? $_SESSION['font_size'] : 'medium';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Answers</title>
    <link rel="stylesheet" href="../CSS/font_sizes.css">
    <link rel="stylesheet" href="../CSS/<?php echo $css_folder; ?>/Quiz_Answers.css">
    <style>
        :root {
            --font-size-base: var(--font-size-<?php echo $font_size; ?>);
        }
    </style>
</head>
<body>
    <header>
        <a href="../HTML/User_Dashboard.php"><img src="../IMG/logo.png" alt="EDG Logo" class="header-logo"></a>
    </header>
    <div class="answers-container">
        <?php
        include '../PHP/conn.php';


        // Fetch all questions and their correct answers
        $sql = "SELECT q.Question_Text, c.Choice_text FROM questions q JOIN choices c ON q.Questions_id = c.Question_id WHERE c.Is_correct = 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><thead><tr><th>Questions</th><th>Answer</th></tr></thead><tbody>";
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . htmlspecialchars($row["Question_Text"]) . "</td><td>" . htmlspecialchars($row["Choice_text"]) . "</td></tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No results found.</p>";
        }

        $conn->close();
        ?>
    </div>
    <footer>
        <a href="../HTML/Choose_Quiz.php" class="footer-link">Choose Another Quiz</a>
    </footer>
</body>
</html>
