<?php
session_start();
session_destroy(); // Destroy all session data
header("Location: ../HTML/Login.html"); // Redirect to login page
exit();
?>
