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
        <div class="flex-container">
            <div class="form-container">
                <form action="Quiz_Answers.php" method="GET" class="filter-form">
                    <label for="category">Filter by Category:</label>
                    <select name="category" id="category">
                        <option value="all" <?php if (!isset($_GET['category']) || $_GET['category'] == 'all') echo 'selected'; ?>>ALL</option>
                        <?php
                        include '../PHP/conn.php';
                        $categories_sql = "SELECT Category_id, Category_Name, Parent_id FROM category WHERE Parent_id IS NOT NULL";
                        $categories_result = $conn->query($categories_sql);

                        $categories = [];
                        if ($categories_result->num_rows > 0) {
                            while ($row = $categories_result->fetch_assoc()) {
                                $categories[$row['Parent_id']][] = $row;
                            }
                        }

                        $parent_category_symbols = [
                            1 => "+",
                            2 => "-",
                            3 => "*",
                            4 => "/"
                        ];

                        foreach ($categories as $parent_id => $subcategories) {
                            $parent_category_symbol = $parent_category_symbols[$parent_id];
                            echo "<optgroup label='$parent_category_symbol'>";
                            foreach ($subcategories as $subcategory) {
                                $selected = (isset($_GET['category']) && $_GET['category'] == $subcategory['Category_id']) ? 'selected' : '';
                                echo "<option value='{$subcategory['Category_id']}' $selected>{$subcategory['Category_Name']}</option>";
                            }
                            echo "</optgroup>";
                        }
                        ?>
                    </select>
                    <button type="submit" class="filter-button">Filter</button>
                </form>
            </div>
        </div>
        
        <?php
        // Fetch filtered questions and their correct answers
        $filter_category_id = $_GET['category'] ?? 'all';
        $sql = "SELECT q.Question_Text, c.Choice_text FROM questions q JOIN choices c ON q.Questions_id = c.Question_id WHERE c.Is_correct = 1";
        if ($filter_category_id !== 'all') {
            $sql .= " AND q.Category_id='$filter_category_id'";
        }
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><thead><tr><th>Questions</th><th>Answer</th></tr></thead><tbody>";
            // Output data of each row
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
