<?php
session_start();  // Start the session or continue the existing one
$color_mode = isset($_SESSION['color_mode']) ? $_SESSION['color_mode'] : 0;
$css_folder = $color_mode ? "tritanopia" : "protanopia";
unset($_SESSION['quiz_over']);

// Check if category_id is provided in the URL
if (isset($_GET['category_id'])) {
    $category_id = intval($_GET['category_id']);
    $_SESSION['category_id'] = $category_id;  // Set category_id in the session
    $_SESSION['question_index'] = 0;  // Optionally, initialize or reset the question index for the new category

    // Determine the appropriate quiz page based on the category_id range
    if ($category_id >= 5 && $category_id <= 8) {
        $redirectPage = "../HTML/Quiz.php";
    } elseif ($category_id >= 9 && $category_id <= 12) {
        $redirectPage = "../HTML/Quiz.php";
    } elseif ($category_id >= 13 && $category_id <= 16) {
        $redirectPage = "../HTML/Quiz.php";
    } elseif ($category_id >= 17 && $category_id <= 20) {
        $redirectPage = "../HTML/Quiz.php";
    } else {
        // If the category_id does not fall into any expected range
        echo "Category ID is out of expected range.";
        header("Location: Choose_Quiz.php"); // Redirect to the quiz selection page
        exit;
    }

    // Redirect to the determined quiz page
    header("Location: $redirectPage");
    exit;
} else {
    echo "No category specified.";
    // Redirect back to a default page or error handling
    header("Location: Choose_Quiz.php");
    exit;
}

