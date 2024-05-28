<?php
session_start();

if (!isset($_SESSION['User_id'])) {
    // Redirect to login page if the user is not logged in
    echo '<script>window.location.href = "../HTML/Login.html";</script>';
    exit();
}

include 'conn.php';

$user_id = $_SESSION['User_id']; // Use the session user ID

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you only have update function for users editing their profile
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $DOB = $_POST['DOB'];
    $Gender = $_POST['Gender'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Email = $_POST['Email'];

    $sql = "UPDATE users SET FirstName=?, LastName=?, DOB=?, Gender=?, PhoneNumber=?, Email=? WHERE User_id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssssssi", $FirstName, $LastName, $DOB, $Gender, $PhoneNumber, $Email, $user_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo '<script>alert("Profile updated successfully"); window.location.href = "../HTML/User_Dashboard.php";</script>';
        } else {
            echo '<script>alert("No changes made to the profile or update failed."); window.location.href = "../HTML/Edit_Profile.php";</script>';
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    // Retrieve user information to display in form
    $sql = "SELECT FirstName, LastName, DOB, Gender, PhoneNumber, Email FROM users WHERE User_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        // Load the form with the user's data
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile Information</title>
    <link rel="stylesheet" href="../CSS/manage_users.css">
</head>
<body>  
    <form action="Edit_Profile.php" method="POST">
        <h1>Edit Your Profile</h1>
        <label for="FirstName">First Name:</label>
        <input type="text" id="FirstName" name="FirstName" value="<?php echo htmlspecialchars($row['FirstName']); ?>">
        <br>
        <label for="LastName">Last Name:</label>
        <input type="text" id="LastName" name="LastName" value="<?php echo htmlspecialchars($row['LastName']); ?>">
        <br>
        <label for="DOB">DOB:</label>
        <input type="date" id="DOB" name="DOB" value="<?php echo $row['DOB']; ?>">
        <br>
        <label for="Gender">Gender:</label>
        <select id="Gender" name="Gender">
            <option value="male" <?php if($row['Gender'] == 'male') echo 'selected'; ?>>Male</option>
            <option value="female" <?php if($row['Gender'] == 'female') echo 'selected'; ?>>Female</option>
            <option value="others" <?php if($row['Gender'] == 'others') echo 'selected'; ?>>Others</option>
        </select>
        <br>
        <label for="PhoneNumber">Phone Number:</label>
        <input type="text" id="PhoneNumber" name="PhoneNumber" value="<?php echo htmlspecialchars($row['PhoneNumber']); ?>">
        <br>
        <label for="Email">Email:</label>
        <input type="email" id="Email" name="Email" value="<?php echo htmlspecialchars($row['Email']); ?>">
        <br>
        <div class="button-group">
            <button type="submit">Update</button>
            <button type="button" onclick="window.location.href='../HTML/Profile_Page.php'">Cancel</button>
        </div>
        <div class="form-footer">
            <a href="Reset_Password.html">Reset Password</a>
        </div>
    </form>
</body>
</html>

        <?php
    } else {
        echo "<p>User not found.</p>";
    }
    $stmt->close();
}
$conn->close();
?>
