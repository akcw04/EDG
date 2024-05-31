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
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../CSS/font_sizes.css">
    <link rel="stylesheet" href="../CSS/<?php echo $css_folder; ?>/User_Dashboard.css">
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
          <a href="#section1" class="nav-link">
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
          <a href="#section2" class="nav-link">
            <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 448 512" fill="white"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
            <span class="link-text">Profile</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="#section3" class="nav-link">
            <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 448 512" fill="white"><path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
            <span class="link-text">Materials</span>
          </a>
        </li>
  
        <li class="nav-item">
          <a href="#section4" class="nav-link">
            <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 384 512" fill="white"><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>          
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
          <a href="section5" class="nav-link">
            <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 650 520" fill="white"><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>          
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
      <section id="section1">
        <div id="part1" >
            <img src="../IMG/user_dashboard_bg.png" alt="user_dashboard_bg" class="user_dashboard_bg">
            <h1>Welcome Astronaut!<br>to Your Math<br>E- Learning Platform</h1>
        </div>
      </section>


      <section id="section2">
        <div id="part3">
          <hr class="new1">
          <h1>Submitted The Wrong Information?</h1>
          <h2>Check Out Your Profile Section !</h2>
          <div class="profile_pic_container">
            <a href="http://localhost/EDG/HTML/Profile_Page.php">
              <div class="user_profile_pic">
                <img src="../IMG/user_profile_pic.png" alt="user_profile">
              </div>
            </a>
            <h2>Tap on Your Profile Picture Now !</h2>
          </div>
        </div>
        <div id="part2">
          <div class="marquee">
            <p><b>Are You READY to KICK Start On Your MATH Educational Journey here in Educational Goat's E-Learning Platform ? PREPARE Yourself for a challenging Learning Experience here on EDG where we provide you with whatever we have BEST! Please Try, Please Try !!!!!!!!</b></p>
          </div>
        </div>
      </section>
      


      <section id="section3">
        <h1>Materials</h1>
        <div>
          <a href="../HTML/Addition.php"><img class="img-container" src="../IMG/ud_addition.png" alt="additionbtn"></a>
          <a href="../HTML/Subtraction.php"><img class="img-container" src="../IMG/ud_substraction.png" alt="substractionbtn"></a>
          <a href="../HTML/Multiplication.php"><img class="img-container" src="../IMG/ud_multiply.png" alt="multiplicationbtn"></a>
          <a href="../HTML/Division.php"><img class="img-container" src="../IMG/ud_divide.png" alt="divisionbtn"></a>
        </div>
      </section>

      <section id="section4">
        <h1>Assessments</h1>
        <div class="start_pic_container">
            <div class="start_pic">
              <a href="../HTML/Choose_Quiz.php"><img class="pic" src="../IMG/start_attempting_pic.png" alt="start_attempting_quiz"></a>
            </div>
            <h3>Tap on the Picture to Start Attempting A Quiz Now !
              <br>
              <p class="encourage">Unlock Your Potential with Every Quiz!
                <br>
                <br>
                Embark on a journey of discovery and challenge with EDG Quizzes! 
                <br>Whether you're looking to test your knowledge, improve your skills, or 
                <br>simply have fun, our quizzes offer a unique learning experience. 
                <br>Catering to a wide range of subjects, each quiz is designed to 
                <br>provide insightful feedback and learning opportunities, 
                <br>ensuring that every attempt enhances your 
                <br>understanding and sharpens your mind.
              </p>
            </h3>
        </div>
        <div>
        </div>
      </section>
      
      <section id="section5">
      <h1>About Us</h1>
      
      <p class="About-Us">Welcome to Educational Goat, where curiosity meets fun and learning! Founded by a passionate team of quiz lovers and lifelong learners, Educational Goat is dedicated to creating a vibrant community through interactive quizzes. The unique part of website is that it is friendly to protanopia and tritanopia users. Our platform offers tutorials for basic math, which included the materials for the users to learn, then assessments which allows the users to evaluate themselves. At Educational Goat, we believe in the power of knowledge and the joy of discovery. Whether you're looking to challenge yourself, compete with friends, or simply explore new subjects, our quizzes are designed to educate, entertain, and inspire. Join us on this exciting journey of learning, one question at a time!</p> 
      
      <div class="Banner-Wrapper">
        <div>
          <img src="../IMG/lion.png" alt="lion">
        </div>
        <div>
          <img src="../IMG/elephant.png" alt="lion">
        </div>
        <div>
          <img src="../IMG/giraffe.png" alt="lion">
        </div>
        <div>
          <img src="../IMG/turtle.png" alt="lion">
        </div>
        <div>
          <img src="../IMG/shark.png" alt="lion">
        </div>
        <div>
          <img src="../IMG/fox.png" alt="lion">
        </div>
      </div>

      <div>

      <div class="About-EDG">
        <h2>EDG - Educational Goat</h2>
      </div>
      <div class="EDG-Logo">
        <img src="../IMG/logo.png" class="logo-style" ></img>
      </div>
      <div class="About-EDG-Text">
        <p>What is Educational Goat? Educational Goat is founded by 4 students from the Asian Pacific University of Technology and Innovation. It is dedicated to transform the way mathematics is learned and taught, specifically designed for individuals with protanopia and tritanopia color-blindness. Our platform features a user-friendly interface and specially adapted visual content that enhances learning without the barrier of color visibility issues. At Educational Goat, we believe that everyone deserves access to quality math education.</p>
      </div>
      <div class="Contributers-Header">
        <p>Below are the contributers of Educational Goat.</p> 
      </div>
      <div class="Contributers-Content-Wrapper"> <!-- Wrapper to hold contributers box -->
        
        <div> <!-- Box to hold image and caption of contributers -->
          <div class="Contributers-IMG">
            <img src="../IMG/astronaut1.png" alt="Contributer1" class="Contributers-IMG-Style">
          </div>
          <div class="Contributers-Caption">
            <p>Annie Kiu Chi Wen</p>
          </div>
        </div>

        <div> 
          <div class="Contributers-IMG">
            <img src="../IMG/astronaut2.png" alt="Contributer2" class="Contributers-IMG-Style">
          </div>
          <div class="Contributers-Caption">
            <p>Chua Kian Ho</p>
          </div>
        </div>

        <div> 
          <div class="Contributers-IMG">
            <img src="../IMG/astronaut3.png" alt="Contributer3" class="Contributers-IMG-Style">
          </div>
          <div class="Contributers-Caption">
            <p>Ding Der-Xin</p>
          </div>
        </div>

        <div> 
          <div class="Contributers-IMG">
            <img src="../IMG/astronaut4.png" alt="Contributer4" class="Contributers-IMG-Style">
          </div>
          <div class="Contributers-Caption">
            <p>Cheng Xi Hong</p>
          </div>
        </div>
        
      </div>

      <div class="Contact-Us">
        <div class="Contact-Us-Header">
          <h2>Contact us if you have any inquires!</h2>
        </div>
        <div class="Contact-Us-Icon-Wrapper">
          <div class="Icon-Box">
            <a href="https://facebook.com">
            <svg xmlns="http://www.w3.org/2000/svg" height= "100" width= "100" viewBox="0 0 512 512"><path d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"/></svg>
            </a>
          </div>
          <div class="Icon-Box">
            <a href="https://instagram.com">
            <svg xmlns="http://www.w3.org/2000/svg" height= "100" width= "100" viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
            </a>
          </div>
          <div class="Icon-details">
            <svg xmlns="http://www.w3.org/2000/svg" height= "100" width= "100" viewBox="0 0 512 512"><path d="M64 112c-8.8 0-16 7.2-16 16v22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1V128c0-8.8-7.2-16-16-16H64zM48 212.2V384c0 8.8 7.2 16 16 16H448c8.8 0 16-7.2 16-16V212.2L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64H448c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128z"/></svg>
            <p class="Email">Email: edg@mail.edu.my</p>
          </div>
          <div class="Icon-details">
            <svg xmlns="http://www.w3.org/2000/svg" height= "100" width= "100" viewBox="0 0 512 512"><path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>
            <p class="Phone-Number">Tel: 012-3456789</p>
          </div>
        </div>
      </div>
    </div>
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