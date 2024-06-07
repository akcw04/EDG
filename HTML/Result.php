<?php
session_start();
$color_mode = isset($_SESSION['color_mode']) ? $_SESSION['color_mode'] : 0;
$css_folder = $color_mode ? "tritanopia" : "protanopia";
$font_size = isset($_SESSION['font_size']) ? $_SESSION['font_size'] : 'medium';

if (!isset($_SESSION['User_id'])) {
    die('User ID is not set in the session.');
}

include '../PHP/conn.php';

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results Page</title>
    <script defer src="../Javascript/script.js"></script>
    <link rel="stylesheet" href="../CSS/font_sizes.css">
    <link rel="stylesheet" href="../CSS/<?php echo $css_folder; ?>/Result.css">
    <link rel="stylesheet" href="../CSS/Results_Page.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <style>
        :root {
            --font-size-base: var(--font-size-<?php echo $font_size; ?>);
        }

        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
            border-radius: 10px;
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .button-group {
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

        .confirm-button, .rechoose-design-button {
            background-color: #1c1c1c;
            color: white;
        }

        .confirm-button:hover, .rechoose-design-button:hover {
            background-color: #FFD1DC;
            color: black;
        }

        .logout-button, .cancel-button {
            background-color: #ccc;
            color: black;
        }

        .logout-button:hover, .cancel-button:hover {
            background-color: #bbb;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background-color: #f4f4f9;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-left: 3rem;
            width: 92%;
        }

        .form-container, .button-container {
            display: flex;
            align-items: center;
        }

        .filter-form {
            display: flex;
            align-items: center;
        }

        .filter-form label {
            margin-right: 10px;
            font-size: 16px;
        }

        .filter-form select {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-right: 10px;
            width: 80%;
        }

        .filter-button, .add-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #1c1c1c;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .filter-button:hover, .add-button:hover {
            background-color: #FFD1DC;
            color: black;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <ul class="navbar-nav">
            <li class="logo">
                <a href="../HTML/User_Dashboard.php" class="nav-link">
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
                <a href="../HTML/Profile_Page.php" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 448 512" fill="white">
                        <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/>
                    </svg>
                    <span class="link-text">Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="../HTML/Addition.php" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 448 512" fill="white">
                        <path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                    </svg>
                    <span class="link-text">Materials</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="../HTML/Choose_Quiz.php" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 384 512" fill="white">
                        <path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                    </svg>
                    <span class="link-text">Quiz</span>
                </a>
            </li>
                        
            <li class="nav-item">
                <a href="../HTML/Result.php" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="white"><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
                    <span class="link-text">Score</span>  
                </a>
            </li>
    
            <li class="nav-item">
                <a href="../HTML/User_Dashboard.php#section5" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 650 520" fill="white">
                        <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/>
                    </svg>
                    <span class="link-text">About Us</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link" onclick="openSettingsModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="white">
                        <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/>
                    </svg>
                    <span class="link-text">Settings</span>
                </a>
            </li>
        </ul>
    </nav>

    <header>
        <a href="../HTML/User_Dashboard.php"><img src="../IMG/logo.png" alt="EDG Logo" class="header-logo"></a>
    </header>

    <main>
        <div class="flex-container">
            <div class="form-container">
                <form action="Result.php" method="GET" class="filter-form">
                    <label for="category">Filter by Category:</label>
                    <select name="category" id="category">
                        <option value="all" <?php if (!isset($_GET['category']) || $_GET['category'] === 'all') echo 'selected'; ?>>ALL</option>
                        <?php
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

        <section>
            <h1>Your Quiz Results</h1>
            <?php
            $user_id = $_SESSION['User_id'];
            $filter_category_id = $_GET['category'] ?? 'all';
            $category_filter = $filter_category_id !== 'all' ? "AND q.Category_id = '$filter_category_id'" : '';
            
            // Fetch the latest quiz results for the user
            $sql = "SELECT q.Quiz_id, q.Score, c.Category_Name, pc.Category_Name as Parent_name,
                        (SELECT COUNT(*) FROM questions WHERE Category_id=q.Category_id) as total_questions,
                        (SELECT COUNT(*) FROM user_answers ua WHERE ua.Quiz_id=q.Quiz_id AND ua.Is_correct=1) as correct_answers 
                    FROM quiz q 
                    JOIN category c ON q.Category_id = c.Category_id
                    LEFT JOIN category pc ON c.Parent_id = pc.Category_id
                    WHERE q.User_id = ? $category_filter 
                    AND q.Quiz_id = (SELECT MAX(Quiz_id) FROM quiz WHERE User_id = q.User_id AND Category_id = q.Category_id)
                    ORDER BY q.Quiz_id DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();


            if ($result->num_rows > 0) {
                echo "<div class='results-container'>";
                while ($row = $result->fetch_assoc()) {
                    $percentage = ($row['total_questions'] > 0) ? ($row['correct_answers'] / $row['total_questions']) * 100 : 0;
                    echo "<div class='result-card'>";
                    echo "<h2>" . htmlspecialchars($row['Parent_name'] . " - " . $row['Category_Name']) . "</h2>";
                    echo "<p>Correct Answers: " . $row['correct_answers'] . " out of " . $row['total_questions'] . "</p>";
                    echo "<p>Percentage: " . round($percentage, 2) . "%</p>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>No quiz results found.</p>";
            }

            $conn->close();
            ?>
        </section>
    </main>

    <div id="settings-modal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeSettingsModal()">&times;</span>
            <p>Settings</p>
            <div class="button-group">
                <button class="rechoose-design-button" onclick="rechooseDesign()">Reset Design</button>
                <br>
                <button class="logout-button" onclick="openLogoutConfirmationModal()">Logout</button>
            </div>
        </div>
    </div>

    <div id="logout-confirmation-modal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeLogoutConfirmationModal()">&times;</span>
            <p>Are you sure you want to log out?</p>
            <form method="POST" action="../PHP/logout.php">
                <div class="button-group">
                    <button type="submit" name="confirm_logout" class="cancel-button">Yes</button>
                    <button type="button" class="confirm-button" onclick="closeLogoutConfirmationModal()">No</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openSettingsModal() {
            document.getElementById('settings-modal').style.display = 'block';
        }

        function closeSettingsModal() {
            document.getElementById('settings-modal').style.display = 'none';
        }

        function openLogoutConfirmationModal() {
            document.getElementById('settings-modal').style.display = 'none'; // Close the settings modal
            document.getElementById('logout-confirmation-modal').style.display = 'block';
        }

        function closeLogoutConfirmationModal() {
            document.getElementById('logout-confirmation-modal').style.display = 'none';
        }

        function rechooseDesign() {
            window.location.href = "../HTML/Pick_Color.html";
        }
    </script>
</body>
</html>
