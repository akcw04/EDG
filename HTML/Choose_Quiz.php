<?php
$color_mode = isset($_SESSION['color_mode']) ? $_SESSION['color_mode'] : 0;
$css_folder = $color_mode ? "tritanopia" : "protanopia";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Page</title>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script defer src="../Javascript/Sample_Materials.js"></script>
        <link rel="stylesheet" href="../CSS/Choose_Quiz.css" />
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
              <a href="#section2" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 448 512" fill="white"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                <span class="link-text">Addition</span>
              </a>
            </li>
      
            <li class="nav-item">
              <a href="#section3" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 448 512" fill="white"><path d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z"/></svg>
                <span class="link-text">Subtraction</span>
              </a>
            </li>
      
            <li class="nav-item">
              <a href="#section4" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 384 512" fill="white"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>                
                <span class="link-text">Multiplication</span>
              </a>
            </li>
      
            <li class="nav-item">
              <a href="#section5" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 448 512" fill="white"><path d="M272 96a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 320a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM400 288c17.7 0 32-14.3 32-32s-14.3-32-32-32H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H400z"/></svg>
                <span class="link-text">Division</span>
              </a>
            </li>
      
            <li class="nav-item">
              <a href="#" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 512 512" fill="white"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
                <span class="link-text">Settings</span>
              </a>
            </li>
          </ul>
        </nav>
      
        <main>
            <div id="section2">
                <section id="section_bg">
                    <h2>Addition</h2>
                </section>
                <div class="addition">
                    <a href="../PHP/choose_quiz.php?category_id=5"><img class="img-container" src="../IMG/addition_quiz_1.png" alt="addition_quiz_1"></a>
                    <a href="../PHP/choose_quiz.php?category_id=6"><img class="img-container" src="../IMG/addition_quiz_2.png" alt="addition_quiz_2"></a>
                    <a href="../PHP/choose_quiz.php?category_id=7"><img class="img-container" src="../IMG/addition_quiz_3.png" alt="addition_quiz_3"></a>
                    <a href="../PHP/choose_quiz.php?category_id=8"><img class="img-container" src="../IMG/addition_quiz_4.png" alt="addition_quiz_4"></a>
                </div>
            </div>
       
        <div id="section3">
          <section id="section_bg">
            <h2>Subtraction</h2>
          </section>
        <div class="subtraction">
            <a href="../PHP/choose_quiz.php?category_id=9"><img class="img-container" src="../IMG/subtraction_quiz_1.png" alt="subtraction_quiz_1"></a>
            <a href="../PHP/choose_quiz.php?category_id=10"><img class="img-container" src="../IMG/subtraction_quiz_2.png" alt="subtraction_quiz_2"></a>
            <a href="../PHP/choose_quiz.php?category_id=11"><img class="img-container" src="../IMG/subtraction_quiz_3.png" alt="subtraction_quiz_3"></a>
            <a href="../PHP/choose_quiz.php?category_id=12"><img class="img-container" src="../IMG/subtraction_quiz_4.png" alt="subtraction_quiz_4"></a>
        </div>

        <div id="section4">
            <section id="section_bg">
                <h2>Multiplication</h2>
            </section>
        <div class="multiply">
            <a href="../PHP/choose_quiz.php?category_id=13"><img class="img-container" src="../IMG/multiply_quiz_1.png" alt="multiply_quiz_1"></a>
            <a href="../PHP/choose_quiz.php?category_id=14"><img class="img-container" src="../IMG/multiply_quiz_2.png" alt="multiply_quiz_2"></a>
            <a href="../PHP/choose_quiz.php?category_id=15"><img class="img-container" src="../IMG/multiply_quiz_3.png" alt="multiply_quiz_3"></a>
            <a href="../PHP/choose_quiz.php?category_id=16"><img class="img-container" src="../IMG/multiply_quiz_4.png" alt="multiply_quiz_4"></a>
        </div>


        <div id="section5">
            <section id="section_bg">
                <h2>Division</h2>
            </section>
            <div class="division">
                <a href="../PHP/choose_quiz.php?category_id=17"><img class="img-container" src="../IMG/division_quiz_1.png" alt="division_quiz_1"></a>
                <a href="../PHP/choose_quiz.php?category_id=18"><img class="img-container" src="../IMG/division_quiz_2.png" alt="division_quiz_2"></a>
                <a href="../PHP/choose_quiz.php?category_id=19"><img class="img-container" src="../IMG/division_quiz_3.png" alt="division_quiz_3"></a>
                <a href="../PHP/choose_quiz.php?category_id=20"><img class="img-container" src="../IMG/division_quiz_4.png" alt="division_quiz_4"></a>
            </div>
        </div>
          <br>
          <br>
          <br>
          <br>
          <br>
        </main>
      </body>