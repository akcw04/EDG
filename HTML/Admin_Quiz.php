<?php
include '../PHP/conn.php';

// Handle form submissions for add, edit, delete
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];
    $id = $_POST["id"] ?? null;

    if ($action == "delete") {
        // First delete associated choices
        $choice_sql = "DELETE FROM choices WHERE Question_id='$id'";
        if ($conn->query($choice_sql) === TRUE) {
            // Then delete the question
            $question_sql = "DELETE FROM questions WHERE Questions_id='$id'";
            if ($conn->query($question_sql) === TRUE) {
                echo '<script>alert("Record deleted successfully"); window.location.href = "Admin_Quiz.php";</script>';
            } else {
                echo "Error deleting question: " . $conn->error;
            }
        } else {
            echo "Error deleting choices: " . $conn->error;
        }
    }
}

// Fetch all categories
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

// Fetch questions and their choices
$filter_category_id = $_GET['category'] ?? null;
$questions_sql = "SELECT q.Questions_id, q.Category_id, q.Question_Text, c.Choice_text, c.Is_correct
                  FROM questions q
                  LEFT JOIN choices c ON q.Questions_id = c.Question_id";
if ($filter_category_id && $filter_category_id !== 'all') {
    $questions_sql .= " WHERE q.Category_id='$filter_category_id'";
}
$questions_sql .= " ORDER BY q.Questions_id, c.Choice_id";
$result = $conn->query($questions_sql);

$questions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[$row['Questions_id']]['info'] = [
            'Questions_id' => $row['Questions_id'],
            'Category_id' => $row['Category_id'],
            'Question_Text' => $row['Question_Text']
        ];
        $questions[$row['Questions_id']]['choices'][] = [
            'Choice_text' => $row['Choice_text'],
            'Is_correct' => $row['Is_correct']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Admin Quiz</title>
<script defer src="../Javascript/script.js"></script>
<link rel="stylesheet" href="../CSS/Admin_Quiz.css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap" rel="stylesheet"/>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="logo">
            <a href="../HTML/Admin_Dashboard.html" class="nav-link">
                <span class="link-text logo-text">EDG</span>
                <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="angle-double-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-angle-double-right fa-w-14 fa-5x">
                    <g class="fa-group">
                        <path fill="currentColor" d="M224 273L88.37 409a23.78 23.78 0 0 1-33.8 0L32 386.36a23.94 23.94 0 0 1 0-33.89l96.13-96.37L32 159.73a23.94 23.94 0 0 1 0-33.89l22.44-22.79a23.78 23.78 0 0 1 33.8 0L223.88 239a23.94 23.94 0 0 1 .1 34z" class="fa-secondary"></path>
                        <path fill="currentColor" d="M415.89 273L280.34 409a23.77 23.77 0 0 1-33.79 0L224 386.26a23.94 23.94 0 0 1 0-33.89L320.11 256l-96-96.47a23.94 23.94 0 0 1 0-33.89l22.52-22.59a23.77 23.77 0 0 1 33.79 0L416 239a24 24 0 0 1-.11 34z" class="fa-primary"></path>
                    </g>
                </svg>
            </a>
        </li>
        <li class="nav-item">
            <a href="../HTML/Admin_Users.php" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 650 520" fill="white"><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>
                <span class="link-text">Manage Users</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="../HTML/Admin_Quiz.php" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 384 512" fill="white"><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
                <span class="link-text">Manage Quiz</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="../HTML/Admin_Results.php" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="white"><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
                <span class="link-text">User Scores</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" onclick="openModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="white"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
                <span class="link-text">Log Out</span>
            </a>
        </li>
    </ul>
</nav>

<main>
    <h1>Manage Quiz</h1>
    <div class="flex-container">
        <div class="form-container">
            <form method="GET" class="filter-form">
                <label for="category">Filter by Category:</label>
                <select name="category" id="category">
                    <option value="all" <?php if ($filter_category_id === 'all' || !$filter_category_id) echo 'selected'; ?>>ALL</option>
                    <?php
                    foreach ($categories as $parent_id => $subcategories) {
                        $parent_category_symbol = $parent_category_symbols[$parent_id];
                        echo "<optgroup label='$parent_category_symbol'>";
                        foreach ($subcategories as $subcategory) {
                            $selected = $filter_category_id == $subcategory['Category_id'] ? 'selected' : '';
                            echo "<option value='{$subcategory['Category_id']}' $selected>{$subcategory['Category_Name']}</option>";
                        }
                        echo "</optgroup>";
                    }
                    ?>
                </select>
                <button type="submit" class="filter-button">Filter</button>
            </form>
        </div>
        <div class="button-container">
            <button type="button" class="add-button" onclick="window.location.href='../PHP/Add_Quiz.php'">Add Quiz</button>
        </div>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Question ID</th>
                    <th>Parent Category</th>
                    <th>Category</th>
                    <th>Question Text</th>
                    <th>Choices</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($questions)) {
                    foreach ($questions as $question_id => $question) {
                        $category_id = $question['info']['Category_id'];
                        $category_name_sql = "SELECT Category_Name, Parent_id FROM category WHERE Category_id='$category_id'";
                        $category_name_result = $conn->query($category_name_sql);
                        $category_name_row = $category_name_result->fetch_assoc();
                        $category_name = $category_name_row['Category_Name'];
                        $parent_category_id = $category_name_row['Parent_id'];
                        $parent_category_symbol = $parent_category_symbols[$parent_category_id];

echo "<tr>";
echo "<td>" . $question['info']['Questions_id'] . "</td>";
echo "<td>" . $parent_category_symbol . "</td>";
echo "<td>" . $category_name . "</td>";
echo "<td>" . $question['info']['Question_Text'] . "</td>";
echo "<td>";
foreach ($question['choices'] as $index => $choice) {
    $choice_id = $index + 1;
    echo $choice['Choice_text'] . " " . ($choice['Is_correct'] ? "(Correct)" : "") . "<br>";
    echo "<input type='hidden' name='choice$choice_id' value='" . htmlspecialchars($choice['Choice_text']) . "'>";
    echo "<input type='hidden' name='is_correct$choice_id' value='" . $choice['Is_correct'] . "'>";
}
echo "</td>";
echo "<td>
        <form action='../PHP/Edit_Quiz.php' method='GET' style='display:inline-block;'>
            <input type='hidden' name='id' value='" . $question['info']['Questions_id'] . "'>
            <input type='hidden' name='category_id' value='" . $question['info']['Category_id'] . "'>
            <input type='hidden' name='question_text' value='" . htmlspecialchars($question['info']['Question_Text']) . "'>";
foreach ($question['choices'] as $index => $choice) {
    $choice_id = $index + 1;
    echo "<input type='hidden' name='choice$choice_id' value='" . htmlspecialchars($choice['Choice_text']) . "'>";
    echo "<input type='hidden' name='is_correct$choice_id' value='" . $choice['Is_correct'] . "'>";
}
echo "    <button type='submit'>Edit</button>
        </form>
        <form id='deleteForm" . $question['info']['Questions_id'] . "' action='Admin_Quiz.php' method='POST' style='display:inline-block;'>
            <input type='hidden' name='id' value='" . $question['info']['Questions_id'] . "'>
            <input type='hidden' name='action' value='delete'>
            <button type='button' onclick='confirmDelete(" . $question['info']['Questions_id'] . ")'>Delete</button>
        </form>
    </td>";
echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No quizzes found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<div id="logout-modal" class="modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeModal()">&times;</span>
        <p>Are you sure you want to log out?</p>
        <form method="POST" action="../PHP/logout.php">
            <div class="button-group">
                <button type="submit" name="confirm_logout" class="confirm-button">Yes</button>
                <button type="button" class="cancel-button" onclick="closeModal()">No</button>
            </div>
        </form>
    </div>
</div>

<script>
    function confirmDelete(questionId) {
        if (confirm("Are you sure you want to delete this question?")) {
            document.getElementById('deleteForm' + questionId).submit();
        }
    }

    function editQuestion(questionId) {
        document.getElementById('editForm' + questionId).style.display = 'block';
        document.getElementById('displayRow' + questionId).style.display = 'none';
    }

    function openModal() {
        document.getElementById('logout-modal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('logout-modal').style.display = 'none';
    }
</script>
</body>
</html>

<?php
$conn->close();
?>