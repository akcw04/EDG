<?php
session_start();
$color_mode = isset($_SESSION['color_mode']) ? $_SESSION['color_mode'] : 0;
$css_folder = $color_mode ? "tritanopia" : "protanopia";
$font_size = isset($_SESSION['font_size']) ? $_SESSION['font_size'] : 'medium';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subtraction Page</title>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script defer src="../Javascript/Sample_Materials.js"></script>
        <link rel="stylesheet" href="../CSS/font_sizes.css">
        <link rel="stylesheet" href="../CSS/<?php echo $css_folder; ?>/Materials.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap" rel="stylesheet"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
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
                <span class="link-text logo-text" >EDG</span>
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
                      class="fa-secondary"
                    ></path>
                    <path
                      fill="currentColor"
                      d="M415.89 273L280.34 409a23.77 23.77 0 0 1-33.79 0L224 386.26a23.94 23.94 0 0 1 0-33.89L320.11 256l-96-96.47a23.94 23.94 0 0 1 0-33.89l22.52-22.59a23.77 23.77 0 0 1 33.79 0L416 239a24 24 0 0 1-.11 34z"
                      class="fa-primary"
                    ></path>
                  </g>
                </svg>
              </a>
            </li>
      
            <li class="nav-item">
              <a href="../HTML/Addition.php" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 448 512" fill="white"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                <span class="link-text">Addition</span>
              </a>
            </li>
      
            <li class="nav-item">
              <a href="../HTML/Subtraction.php" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 448 512" fill="white"><path d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z"/></svg>
                <span class="link-text">Subtraction</span>
              </a>
            </li>
      
            <li class="nav-item">
              <a href="../HTML/Multiplication.php" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 384 512" fill="white"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>                
                <span class="link-text">Multiplication</span>
              </a>
            </li>
      
            <li class="nav-item">
              <a href="../HTML/Division.php" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 448 512" fill="white"><path d="M272 96a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 320a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM400 288c17.7 0 32-14.3 32-32s-14.3-32-32-32H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H400z"/></svg>
                <span class="link-text">Division</span>
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
          <div class="Title-Box">
            <p class="Title-Text">Subtraction</p> <!-- Title -->
            </div>

            <div class="Introduction-Container"> <!-- Introduction Section -->
              <div>
                <p class="Introduction-Text">Subtraction is a way of finding out how many are left when we take some away. Picture yourself with a box of crayons. If you start with ten crayons and give away three to your friend, subtraction helps you figure out how many crayons you have left. It's like when you're sharing cookies or figuring out how many candies are left after eating some. Subtraction tells us how much remains after something is gone.</p>
              </div>
            </div>
            <div class="Example-One-Container">
            <div class="Example-One-Text-Box">
              <p class="Example-One-Text">Example One</p>
            </div>
            <div class="Example-One-Box1">
              <div class="Text-Content">
                <p class="Text">Imagine we are building a tall tower with ten colorful blocks. </p>
              </div>
              <div class="Image-Content">
                <img src="../IMG/64.png" alt="flower1">
              </div>
            </div>
            <div class="Example-One-Box2">
              <div class="Text-Content">
                <p class="Text">After a while, we decide to remove three blocks to make a smaller tower. </p>
              </div>
              <div class="Image-Content">
                <img src="../IMG/65.png" alt="flower2">
              </div>
            </div>
            <div class="Example-One-Box3">
              <div class="Text-Content">
                <p class="Text">How many blocks are left?</p>
              </div>
              <div class="Image-Content">
                <img src="../IMG/66.png" alt="flower3">
              </div>
            </div>
            <div class="Example-One-Box4">
              <div class="Text-Content">
                <p class="Text">We start with ten and take away three blocks: one, two, three.</p>
              </div>
              <div class="Image-Content">
                <img src="../IMG/67.png" alt="flower3">
              </div>
            </div>
            <div class="Example-One-Box5">
              <div class="Text-Content">
                <p class="Text">Now, let’s count the blocks that are still making up the tower: one, two, three, four, five, six, seven.</p>
              </div>
              <div class="Image-Content">
                <img src="../IMG/68.png" alt="flower4">
              </div>
            </div>
            <div class="Example-One-Box6">
              <div class="Text-Content">
                <p class="Text">Subtraction helps us understand how many are left when we take some away, like when we share our snacks or give away some of our stickers.</p>
              </div>
            </div>
          </div>

          <div class="Example-Two-Container">
            <div class="Example-Two-Text-Box">
              <p class="Example-Two-Text">Example Two</p>
            </div>
            <div class="Example-Two-Box1">
              <div class="Text-Content">
                <p class="Text">Imagine you have seven bright, colorful balloons at your birthday party</p>
              </div>
              <div class="Image-Content">
                <img src="../IMG/69.png" alt="food1">
              </div>
            </div>
            <div class="Example-Two-Box2">
              <div class="Text-Content">
                <p class="Text">Oh no! Two balloons escaped and floated up into the sky</p>
              </div>
              <div class="Image-Content">
                <img src="../IMG/70.png" alt="food2">
              </div>
            </div>
            <div class="Example-Two-Box3">
              <div class="Text-Content">
                <p class="Text">How many balloons are left with you? Let's figure it out together. We start by counting the balloons we have in the beginning.</p>
              </div>
              <div class="Image-Content">
                <img src="../IMG/71.png" alt="food3">
              </div>
            </div>
            <div class="Example-Two-Box4">
              <div class="Text-Content">
                <p class="Text">Then, we count the balloons thagt flew away, one, two.</p>
              </div>
              <div class="Image-Content">
                <img src="../IMG/72.png" alt="food3">
              </div>
            </div>
            <div class="Example-Two-Box5">
              <div class="Text-Content">
                <p class="Text">As we count each one left—five, four, three, yellow, green, and purple—we see there are five balloons remaining.</p>
              </div>
              <div class="Image-Content">
                <img src="../IMG/73.png" alt="food4">
              </div>
            </div>
            <div class="Example-Two-Box6">
              <div class="Text-Content">
                <p class="Text">This shows us that when we subtract two from seven, five balloons are left. Subtraction helps us find out how many things remain after some are taken away.</p>
              </div>
            </div>
          </div>

          <div class="Example-Three-Container">
            <div class="Example-Three-Text-Box">
              <p class="Example-Three-Text">Example Three</p>
            </div>
            <div class="Example-Three-Box1">
              <div class="Text-Content">
                <p class="Text">Imagine a sunny day in the garden where ten happy bees are buzzing around, visiting five colorful flowers.</p>
              </div>
              <div class="Image-Content">
                <img src="../IMG/74.png" alt="icecream1">
              </div>
            </div>
            <div class="Example-Three-Box2">
              <div class="Text-Content">
                <p class="Text">Suddenly, three bees decide to fly back to their hive for a little rest.</p>
              </div>
              <div class="Image-Content">
                <img src="../IMG/75.png" alt="icecream2">
              </div>
            </div>
            <div class="Example-Three-Box3">
              <div class="Text-Content">
                <p class="Text">How many bees are still flying around the flowers? Let's find out together. We start with ten bees and subtract the three bees that flew away. </p>
              </div>
              <div class="Image-Content">
                <img src="../IMG/76.png" alt="icecream5">
              </div>
            </div>
            <div class="Example-Three-Box4">
              <div class="Text-Content">
                <p class="Text">We then, count the bees that flew away, one, two, three.</p>
              </div>
              <div class="Image-Content">
                <img src="../IMG/77.png" alt="icecream3">
              </div>
            </div>
            <div class="Example-Three-Box5">
              <div class="Text-Content">
                <p class="Text">We count the remaining bees as they buzz from flower to flower—seven, six, and finally, we have seven bees left.</p>
              </div>
              <div class="Image-Content">
                <img src="../IMG/78.png" alt="icecream4">
              </div>
            </div>
            <div class="Example-Three-Box6">
              <div class="Text-Content">
                <p class="Text">This helps us see that when we subtract three from ten, we end up with seven buzzing bees.</p>
              </div>
            </div>
            <div class="Outro"> <!-- Subtraction-Outro -->
              <p>Well done on completing your subtraction tutorial! You now know how to find out what's left when something is taken away. This skill is essential for solving everyday problems and will serve you well in future math challenges. Keep up the excellent work!</p>
            </div>

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