<?php
include '../PHP/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $id = $_POST['id'];

    if ($action == 'edit') {
        $sql = "SELECT * FROM users WHERE User_id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title>Edit User</title>
            <link rel="stylesheet" href="../CSS/manage_users.css" />
            </head>
            <body>  
              <form action="manage_user.php" method="POST">
                <h1>Edit User</h1>
                <input type="hidden" name="id" value="<?php echo $row['User_id']; ?>">
                <input type="hidden" name="action" value="update">
                <label for="FirstName">First Name:</label>
                <input type="text" id="FirstName" name="FirstName" value="<?php echo $row['FirstName']; ?>">
                <br>
                <label for="LastName">Last Name:</label>
                <input type="text" id="LastName" name="LastName" value="<?php echo $row['LastName']; ?>">
                <br>
                <label for="DOB">DOB:</label>
                <input type="date" id="DOB" name="DOB" value="<?php echo $row['DOB']; ?>">
                <br>
                <label for="Gender">Gender:</label>
                <input type="text" id="Gender" name="Gender" value="<?php echo $row['Gender']; ?>">
                <br>
                <label for="PhoneNumber">Phone Number:</label>
                <input type="text" id="PhoneNumber" name="PhoneNumber" value="<?php echo $row['PhoneNumber']; ?>">
                <br>
                <label for="Email">Email:</label>
                <input type="email" id="Email" name="Email" value="<?php echo $row['Email']; ?>">
                <br>
                <label for="Role">Role:</label>
                <input type="text" id="Role" name="Role" value="<?php echo $row['Role']; ?>">
                <br>
                <button type="submit">Update</button>
              </form>
            </body>
            </html>
            <?php
        } else {
            echo "User not found.";
        }
    } elseif ($action == 'update') {
        $FirstName = $_POST['FirstName'];
        $LastName = $_POST['LastName'];
        $DOB = $_POST['DOB'];
        $Gender = $_POST['Gender'];
        $PhoneNumber = $_POST['PhoneNumber'];
        $Email = $_POST['Email'];
        $Role = $_POST['Role'];

        $sql = "UPDATE users SET FirstName='$FirstName', LastName='$LastName', DOB='$DOB', Gender='$Gender', PhoneNumber='$PhoneNumber', Email='$Email', Role='$Role' WHERE User_id=$id";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Record updated successfully"); window.location.href = "../HTML/Admin_Users.php";</script>';
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } elseif ($action == 'delete') {
        // First, delete associated records in the quiz table
        $sql_delete_quiz = "DELETE FROM quiz WHERE User_id=$id";
        if ($conn->query($sql_delete_quiz) === TRUE) {
            // Now delete the user
            $sql_delete_user = "DELETE FROM users WHERE User_id=$id";
            if ($conn->query($sql_delete_user) === TRUE) {
                echo '<script>alert("Record deleted successfully"); window.location.href = "../HTML/Admin_Users.php";</script>';
            } else {
                echo "Error deleting user: " . $conn->error;
            }
        } else {
            echo "Error deleting quiz records: " . $conn->error;
        }
    }

    $conn->close();
}
?>
