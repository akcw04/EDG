<?php
session_start();
$color_mode = isset($_SESSION['color_mode']) ? $_SESSION['color_mode'] : 0;
$css_folder = $color_mode ? "tritanopia" : "protanopia";
$font_size = isset($_SESSION['font_size']) ? $_SESSION['font_size'] : 'medium';


// Check if User_id is set in the session before doing anything else
if (!isset($_SESSION['User_id'])) {
    die('User ID is not set in the session.');
}

include '../PHP/conn.php';


// Query to fetch user data
$sql = "SELECT FirstName, LastName, DOB, Gender, PhoneNumber, Email, Password FROM users WHERE User_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die('MySQL prepare error: ' . $conn->error);
}

// Bind the user ID from session
$stmt->bind_param("i", $_SESSION['User_id']);
$stmt->execute();

// Fetch results
$result = $stmt->get_result(); // Get the result set from the prepared statement

if ($userData = $result->fetch_assoc()) {

} else {
    echo "No user found with that ID.";
}

$stmt->close();
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <script defer src="../Javascript/script.js"></script>
    <link rel="stylesheet" href="../CSS/font_sizes.css">
    <link rel="stylesheet" href="../CSS/<?php echo $css_folder; ?>/Profile.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&family=Dosis:wght@200..800&family=Permanent+Marker&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
  
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&family=Dosis:wght@200..800&family=Permanent+Marker&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
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

    </style>
</head>

<body>
    <nav class="navbar">
      <ul class="navbar-nav">
        <li class="logo">
          <a href="../HTML/User_Dashboard.php" class="nav-link">
            <span class="link-text logo-text">EDG</span>
            <svg
              aria-hidden="true"
              focusable="false"
              data-prefix="fad"
              data-icon="angle-double-right"
              role="img"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 448 512"
              class="svg-inline--fa fa-angle-double-right fa-w-14 fa-5x"
            >
              <g class="fa-group">
                <path
                  fill="currentColor"
                  d="M224 273L88.37 409a23.78 23.78 0 0 1-33.8 0L32 386.36a23.94 23.94 0 0 1 0-33.89l96.13-96.37L32 159.73a23.94 23.94 0 0 1 0-33.89l22.44-22.79a23.78 23.78 0 0 1 33.8 0L223.88 239a23.94 23.94 0 0 1 .1 34z"
                  class="fa-secondary">
                </path>
                <path
                  fill="currentColor"
                  d="M415.89 273L280.34 409a23.77 23.77 0 0 1-33.79 0L224 386.26a23.94 23.94 0 0 1 0-33.89L320.11 256l-96-96.47a23.94 23.94 0 0 1 0-33.89l22.52-22.59a23.77 23.77 0 0 1 33.79 0L416 239a24 24 0 0 1-.11 34z"
                  class="fa-primary">
                </path>
              </g>
            </svg>
          </a>
        </li>
  
        <li class="nav-item">
          <a href="../HTML/Profile_Page.php" class="nav-link">
            <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 448 512" fill="white"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
            <span class="link-text">Profile</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="../HTML/Addition.php" class="nav-link">
            <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 448 512" fill="white"><path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
            <span class="link-text">Materials</span>
          </a>
        </li>
  
        <li class="nav-item">
          <a href="../HTML/Choose_Quiz.php" class="nav-link">
            <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 384 512" fill="white"><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>          
            <span class="link-text">Assessments</span>
          </a>
        </li>
  
        <li class="nav-item">
          <a href="../HTML/User_Dashboard.php#section5" class="nav-link">
            <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 650 520" fill="white"><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>          
            <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/>
            </svg>
            <span class="link-text">About Us</span>
          </a>
        </li>
  
  
        <li class="nav-item">
            <a href="#" class="nav-link" onclick="openSettingsModal()">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="white"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
              <span class="link-text">Settings</span>
            </a>
        </li>
      </ul>
    </nav>
  
    <main>
      <section id="section2">
        <div id="top_background">
          <div>
            <h1>Your Personal <br>Profile Section</h1>
              <div class="student_picture_container">
                <img class="student_picture" src="../IMG/profile_bg.png" alt="user_profile">
              </div>
          </div>
        </div>
        <div>
          <div class="profile_container">
            <div class="profile">
              <h2>Your Submitted Information is only collected for Create Account Purpose</h2>
              <div>
                <div class="table_container">
                  <table class="table_design">
                      <tr>
                          <th>First Name :</th>
                          <td><?php echo htmlspecialchars($userData['FirstName']); ?></td>
                      </tr>
                      <tr>
                          <th>Last Name :</th>
                          <td><?php echo htmlspecialchars($userData['LastName']); ?></td>
                      </tr>
                      <tr>
                          <th>Date Of Birth :</th>
                          <td><?php echo htmlspecialchars($userData['DOB']); ?></td>
                      </tr>
                      <tr>
                          <th>Gender :</th>
                          <td><?php echo htmlspecialchars($userData['Gender']); ?></td>
                      </tr>
                      <tr>
                          <th>Phone Number :</th>
                          <td><?php echo htmlspecialchars($userData['PhoneNumber']); ?></td>
                      </tr>
                      <tr>
                          <th>Email :</th>
                          <td><?php echo htmlspecialchars($userData['Email']); ?></td>
                      </tr>
                      <tr>
                          <th>Password :</th>
                          <td>**********</td>
                      </tr>
                      <tr class="button-container">
                        <th><button class="button" name="submit" id="submit" class="edit_button" onclick="window.location.href='../PHP/Edit_Profile.php'"><b>Edit Profile</b></button></th>
                      </tr>
                  </table>
                </div>

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