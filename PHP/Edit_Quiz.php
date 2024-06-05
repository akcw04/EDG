<?php
session_start();

if (!isset($_SESSION['User_id'])) {
    // Redirect to login page if the user is not logged in
    echo '<script>window.location.href = "../HTML/Login.html";</script>';
    exit();
}

include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question_id = $_POST['id'];
    $category_id = $_POST['category'];
    $question_text = $_POST['question'];
    $choices = [
        ['text' => $_POST["choice1"], 'is_correct' => $_POST["is_correct"] == '1' ? 1 : 0],
        ['text' => $_POST["choice2"], 'is_correct' => $_POST["is_correct"] == '2' ? 1 : 0],
        ['text' => $_POST["choice3"], 'is_correct' => $_POST["is_correct"] == '3' ? 1 : 0],
        ['text' => $_POST["choice4"], 'is_correct' => $_POST["is_correct"] == '4' ? 1 : 0]
    ];

    $sql = "UPDATE questions SET Category_id='$category_id', Question_Text='$question_text' WHERE Questions_id='$question_id'";
    if ($conn->query($sql) === TRUE) {
        foreach ($choices as $index => $choice) {
            $choice_id = $index + 1;
            $choice_text = $choice['text'];
            $is_correct = $choice['is_correct'];
            $choice_sql = "UPDATE choices SET Choice_text='$choice_text', Is_correct='$is_correct' WHERE Question_id='$question_id' AND Choice_id='$choice_id'";
            $conn->query($choice_sql);
        }
        echo '<script>alert("Quiz updated successfully"); window.location.href = "../HTML/Admin_Quiz.php";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $question_id = $_GET['id'];
    $sql = "SELECT q.Questions_id, q.Category_id, q.Question_Text, 
            c1.Choice_text AS choice1, c1.Is_correct AS is_correct1, 
            c2.Choice_text AS choice2, c2.Is_correct AS is_correct2, 
            c3.Choice_text AS choice3, c3.Is_correct AS is_correct3, 
            c4.Choice_text AS choice4, c4.Is_correct AS is_correct4
            FROM questions q
            LEFT JOIN choices c1 ON q.Questions_id = c1.Question_id AND c1.Choice_id = 1
            LEFT JOIN choices c2 ON q.Questions_id = c2.Question_id AND c2.Choice_id = 2
            LEFT JOIN choices c3 ON q.Questions_id = c3.Question_id AND c3.Choice_id = 3
            LEFT JOIN choices c4 ON q.Questions_id = c4.Question_id AND c4.Choice_id = 4
            WHERE q.Questions_id='$question_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $category_id = $row['Category_id'];
        $question_text = $row['Question_Text'];
        $choice1 = $row['choice1'];
        $is_correct1 = $row['is_correct1'];
        $choice2 = $row['choice2'];
        $is_correct2 = $row['is_correct2'];
        $choice3 = $row['choice3'];
        $is_correct3 = $row['is_correct3'];
        $choice4 = $row['choice4'];
        $is_correct4 = $row['is_correct4'];
    }
}

// Fetch categories
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Quiz</title>
    <link rel="stylesheet" href="../CSS/Add_Quiz.css" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #ffe6e6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
            color: #555;
        }
        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .button-group {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        .button-group button {
            flex: 1;
            margin: 5px;
            padding: 10px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button[type="submit"] {
            background-color: black;
            color: white;
        }
        button[type="submit"]:hover {
            background-color: #ccc;
            color: black;
        }
    </style>
</head>
<body>

<main>
    <div class="form-container">
        <h1>Edit Quiz</h1>
        <form action="Edit_Quiz.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $question_id; ?>">
            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <?php
                foreach ($categories as $parent_id => $subcategories) {
                    $parent_category_symbol = $parent_category_symbols[$parent_id];
                    echo "<optgroup label='$parent_category_symbol'>";
                    foreach ($subcategories as $subcategory) {
                        $selected = $category_id == $subcategory['Category_id'] ? 'selected' : '';
                        echo "<option value='{$subcategory['Category_id']}' $selected>{$subcategory['Category_Name']}</option>";
                    }
                    echo "</optgroup>";
                }
                ?>
            </select>
            <label for="question">Question Text:</label>
            <input type="text" id="question" name="question" value="<?php echo htmlspecialchars($question_text); ?>" required>
            <label for="choice1">Choice 1:</label>
            <input type="text" id="choice1" name="choice1" value="<?php echo htmlspecialchars($choice1); ?>" required>
            <label for="choice2">Choice 2:</label>
            <input type="text" id="choice2" name="choice2" value="<?php echo htmlspecialchars($choice2); ?>" required>
            <label for="choice3">Choice 3:</label>
            <input type="text" id="choice3" name="choice3" value="<?php echo htmlspecialchars($choice3); ?>" required>
            <label for="choice4">Choice 4:</label>
            <input type="text" id="choice4" name="choice4" value="<?php echo htmlspecialchars($choice4); ?>" required>
            <label for="is_correct">Correct Choice:</label>
            <select name="is_correct" id="is_correct" required>
                <option value="1" <?php if($is_correct1) echo 'selected'; ?>>Choice 1</option>
                <option value="2" <?php if($is_correct2) echo 'selected'; ?>>Choice 2</option>
                <option value="3" <?php if($is_correct3) echo 'selected'; ?>>Choice 3</option>
                <option value="4" <?php if($is_correct4) echo 'selected'; ?>>Choice 4</option>
            </select>
            <div class="button-group">
                  <button type="submit">Update</button>
                  <button type="button" onclick="window.location.href='../HTML/Admin_Quiz.php'">Cancel</button>
            </div>
        </form>
    </div>
</main>

</body>
</html>

<?php
$conn->close();
?>
