<?php
include 'conn.php';

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
            <title>Edit User Profile Information</title>
            <link rel="stylesheet" href="../CSS/manage_users.css" />
            <script>
              function validateForm() {
                var firstName = document.getElementById("FirstName").value;
                var lastName = document.getElementById("LastName").value;
                var dob = document.getElementById("DOB").value;
                var phoneNumber = document.getElementById("PhoneNumber").value;
                var email = document.getElementById("Email").value;
                var role = document.getElementById("Role").value;

                if (firstName == "" || lastName == "" || dob == "" || phoneNumber == "" || email == "" || role == "") {
                  alert("All fields must be filled out");
                  return false;
                }

                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                  alert("Please enter a valid email address");
                  return false;
                }

                var phonePattern = /^[0-9]{10,15}$/;
                if (!phonePattern.test(phoneNumber)) {
                  alert("Please enter a valid phone number");
                  return false;
                }

                return true;
              }
            </script>
            </head>
            <body>  
              <form action="manage_user.php" method="POST" onsubmit="return validateForm()">
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
                <select id="Gender" name="Gender">
                  <option value="male" <?php if($row['Gender'] == 'male') echo 'selected'; ?>>Male</option>
                  <option value="female" <?php if($row['Gender'] == 'female') echo 'selected'; ?>>Female</option>
                  <option value="others" <?php if($row['Gender'] == 'others') echo 'selected'; ?>>Others</option>
                </select>
                <br>
                <label for="PhoneNumber">Phone Number:</label>
                <input type="text" id="PhoneNumber" name="PhoneNumber" value="<?php echo $row['PhoneNumber']; ?>">
                <br>
                <label for="Email">Email:</label>
                <input type="email" id="Email" name="Email" value="<?php echo $row['Email']; ?>">
                <br>
                <label for="Role">Role:</label>
                <select id="Role" name="Role">
                  <option value="0" <?php if($row['Role'] == '0') echo 'selected'; ?>>0</option>
                  <option value="1" <?php if($row['Role'] == '1') echo 'selected'; ?>>1</option>
                </select>
                <br>
                <div class="button-group">
                  <button type="submit">Update</button>
                  <button type="button" onclick="window.location.href='../HTML/Admin_Users.php'">Cancel</button>
                </div>
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
