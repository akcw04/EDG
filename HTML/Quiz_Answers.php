<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Answers</title>
    <link rel="stylesheet" href="../CSS/Quiz_Answers.css" />
</head>
<body>
    <header>
        <a href="../HTML/User_Dashboard.html"><img src="../IMG/logo.png" alt="EDG Logo" class="header-logo"></a>
    </header>
    <div class="answers-container">
        <?php
        // Database connection setup
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "edg";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

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
        <a href="../HTML/Choose_Quiz.html" class="footer-link">Choose Another Quiz</a>
    </footer>
</body>
</html>
