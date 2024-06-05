<?php
session_start();

if (!isset($_SESSION['User_id'])) {
    // Redirect to login page if the user is not logged in
    echo '<script>window.location.href = "../HTML/Login.html";</script>';
    exit();
}

include 'conn.php';

$editing = isset($_GET['id']);
if ($editing) {
    $question_id = $_GET['id'];
    $question_sql = "SELECT * FROM questions WHERE Questions_id = '$question_id'";
    $question_result = $conn->query($question_sql);
    $question = $question_result->fetch_assoc();

    $choices_sql = "SELECT * FROM choices WHERE Question_id = '$question_id'";
    $choices_result = $conn->query($choices_sql);
    $choices = [];
    while ($choice = $choices_result->fetch_assoc()) {
        $choices[] = $choice;
    }
} else {
    $question = [
        'Category_id' => '',
        'Question_Text' => '',
    ];
    $choices = [
        ['Choice_text' => '', 'Is_correct' => 0],
        ['Choice_text' => '', 'Is_correct' => 0],
        ['Choice_text' => '', 'Is_correct' => 0],
        ['Choice_text' => '', 'Is_correct' => 0],
    ];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = $_POST['category'];
    $question_text = $_POST['question'];
    $choices = [
        ['text' => $_POST["choice1"], 'is_correct' => $_POST["is_correct"] == '1' ? 1 : 0],
        ['text' => $_POST["choice2"], 'is_correct' => $_POST["is_correct"] == '2' ? 1 : 0],
        ['text' => $_POST["choice3"], 'is_correct' => $_POST["is_correct"] == '3' ? 1 : 0],
        ['text' => $_POST["choice4"], 'is_correct' => $_POST["is_correct"] == '4' ? 1 : 0]
    ];

    if ($editing) {
        $sql = "UPDATE questions SET Category_id='$category_id', Question_Text='$question_text' WHERE Questions_id='$question_id'";
        if ($conn->query($sql) === TRUE) {
            foreach ($choices as $index => $choice) {
                $choice_text = $choice['text'];
                $is_correct = $choice['is_correct'];
                $choice_id = $index + 1;
                $choice_sql = "UPDATE choices SET Choice_text='$choice_text', Is_correct='$is_correct' WHERE Question_id='$question_id' AND Choice_id='$choice_id'";
                $conn->query($choice_sql);
            }
            echo '<script>alert("Quiz updated successfully"); window.location.href = "../HTML/Admin_Quiz.php";</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $sql = "INSERT INTO questions (Category_id, Question_Text) VALUES ('$category_id', '$question_text')";
        if ($conn->query($sql) === TRUE) {
            $question_id = $conn->insert_id;
            foreach ($choices as $choice) {
                $choice_text = $choice['text'];
                $is_correct = $choice['is_correct'];
                $choice_sql = "INSERT INTO choices (Question_id, Choice_text, Is_correct) VALUES ('$question_id', '$choice_text', '$is_correct')";
                $conn->query($choice_sql);
            }
            echo '<script>alert("Quiz added successfully"); window.location.href = "../HTML/Admin_Quiz.php";</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
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
    <title><?php echo $editing ? 'Edit Quiz' : 'Add New Quiz'; ?></title>
    <link rel="stylesheet" href="../PHP/Add_Quiz.php" />
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
    </style
    </style>
</head>
<body>

<main>
    <div class="form-container">
        <h1><?php echo $editing ? 'Edit Quiz' : 'Add New Quiz'; ?></h1>
        <form action="Add_Quiz.php" method="POST">
            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <?php
                foreach ($categories as $parent_id => $subcategories) {
                    $parent_category_symbol = $parent_category_symbols[$parent_id];
                    echo "<optgroup label='$parent_category_symbol'>";
                    foreach ($subcategories as $subcategory) {
                        $selected = $subcategory['Category_id'] == $question['Category_id'] ? 'selected' : '';
                        echo "<option value='{$subcategory['Category_id']}' $selected>{$subcategory['Category_Name']}</option>";
                    }
                    echo "</optgroup>";
                }
                ?>
            </select>
            <label for="question">Question Text:</label>
            <input type="text" id="question" name="question" value="<?php echo htmlspecialchars($question['Question_Text']); ?>" required>
            <label for="choice1">Choice 1:</label>
            <input type="text" id="choice1" name="choice1" value="<?php echo htmlspecialchars($choices[0]['Choice_text']); ?>" required>
            <label for="choice2">Choice 2:</label>
            <input type="text" id="choice2" name="choice2" value="<?php echo htmlspecialchars($choices[1]['Choice_text']); ?>" required>
            <label for="choice3">Choice 3:</label>
            <input type="text" id="choice3" name="choice3" value="<?php echo htmlspecialchars($choices[2]['Choice_text']); ?>" required>
            <label for="choice4">Choice 4:</label>
            <input type="text" id="choice4" name="choice4" value="<?php echo htmlspecialchars($choices[3]['Choice_text']); ?>" required>
            <label for="is_correct">Correct Choice:</label>
            <select name="is_correct" id="is_correct" required>
                <option value="1" <?php if($choices[0]['Is_correct']) echo 'selected'; ?>>Choice 1</option>
                <option value="2" <?php if($choices[1]['Is_correct']) echo 'selected'; ?>>Choice 2</option>
                <option value="3" <?php if($choices[2]['Is_correct']) echo 'selected'; ?>>Choice 3</option>
                <option value="4" <?php if($choices[3]['Is_correct']) echo 'selected'; ?>>Choice 4</option>
            </select>
            <div class="button-group">
                <button type="submit"><?php echo $editing ? 'Update' : 'Add'; ?> Quiz</button>
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
