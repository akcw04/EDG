# Educational Goat (EDG)

A math-education web application built specifically for learners with **partial colour blindness** — primarily **protanopia** (red–green) and **tritanopia** (blue–yellow). EDG re-skins the entire learning experience with colour palettes and typography choices tuned for each deficiency, so students who normally struggle to read standard educational content can study, take quizzes, and review results comfortably.

The project pairs an accessible front-end (HTML / CSS / JavaScript) with a PHP + MySQL back-end, and includes both a learner-facing experience and an admin panel for managing users, quizzes, and results.

---

## What this project does

EDG is split across three user journeys:

### 1. Accessibility-first onboarding

When a new user signs up, they are walked through two customisation steps before they ever reach the learning content:

- **Pick Color Mode** — choose between a *protanopia-friendly* palette (blue-leaning, avoids red/green confusion) or a *tritanopia-friendly* palette (green-leaning, avoids blue/yellow confusion). The choice is persisted to the user's account and switches the stylesheet bundle they get on every subsequent page.
- **Pick Size** — choose a base font size profile so users with low vision (or who simply prefer larger text) get a comfortable reading experience across the whole app.

### 2. Learning + quizzing

Once configured, the user lands on a personalised dashboard giving access to:

- **Math content pages** — four core arithmetic topics (Addition, Subtraction, Multiplication, Division), each rendered using the user's chosen colour and size profile.
- **Sample materials** — supporting reference material learners can browse outside of quiz mode.
- **Quizzes** — pick a quiz, attempt it, then review every answer with feedback.
- **Results** — every quiz attempt is stored and can be reviewed afterwards.
- **Profile page** — edit personal details, switch colour mode, or change size at any time.

### 3. Admin panel

A separate admin role gets:

- **Admin Dashboard** — overview screen.
- **Manage Users** — list, edit, and remove user accounts.
- **Manage Quizzes** — add, edit, and remove quiz questions and answer options.
- **View Results** — see every quiz attempt across all users.

Authentication includes signup with client-side validation, login, a *Forgot Password* flow that emails a reset token via **PHPMailer**, and a corresponding *Reset Password* form.

---

## How it works

### Architecture

EDG is a classic LAMP-style application — no framework, just PHP scripts talking directly to MySQLi:

```
Browser
  │
  │  HTTP request → http://localhost/EDG/HTML/<page>.html or .php
  ▼
HTML / PHP page (HTML/)
  │
  │  <form action="../PHP/<handler>.php">
  ▼
PHP handler (PHP/)
  │
  ▼
conn.php  ──►  MySQL database "edg"
  │
  ▼
Response: redirect back to a page, with session state updated
```

The colour and size accessibility layer is implemented by **swapping which CSS files the page loads** based on the user's saved profile. Each accessibility-aware page has three CSS variants:

```
CSS/<Page>.css                   ← default
CSS/protanopia/<Page>.css        ← protanopia-friendly recolour
CSS/tritanopia/<Page>.css        ← tritanopia-friendly recolour
```

PHP picks the right stylesheet at render time based on the user's `color_mode` and `font_size` columns.

### Directory layout

```
EDG/
├── HTML/                        # User-facing pages (HTML + .php views)
│   ├── Login.html, Signup.html, Forgot/Reset_Password.html
│   ├── Dashboard.html, User_Dashboard.php, Profile_Page.php
│   ├── Pick_Color.html, Pick_Size.html
│   ├── Addition.php, Subtraction.php, Multiplication.php, Division.php
│   ├── Choose_Quiz.php, Quiz.php, Quiz_Answers.php, Result.php
│   ├── Sample_Materials.html
│   └── Admin_Dashboard.html, Admin_Users.php, Admin_Quiz.php, Admin_Results.php
│
├── PHP/                         # Server-side handlers
│   ├── conn.php                 #   MySQL connection
│   ├── login_check.php, submit_form.php (signup)
│   ├── forgot_password.php, reset_password.php
│   ├── pick_color.php, pick_size.php
│   ├── choose_quiz.php, quiz.php
│   ├── Add_Quiz.php, Edit_Quiz.php
│   ├── manage_user.php, Edit_Profile.php
│   └── logout.php
│
├── CSS/                         # Stylesheets
│   ├── *.css                    #   Default theme
│   ├── protanopia/*.css         #   Protanopia recolour
│   ├── tritanopia/*.css         #   Tritanopia recolour
│   └── font_sizes.css           #   Adjustable typography
│
├── Javascript/                  # Client-side validation + interactivity
│   ├── Login_Validation.js, Signup_Validation.js
│   ├── Forgot_Password.js
│   ├── Quiz.js, Sample_Materials.js
│   └── script.js
│
├── IMG/                         # Images used across the app
│
├── composer.json                # Composer config (PHPMailer)
├── vendor/                      # Composer dependencies (gitignored)
├── README.md
└── SDP Project Doc.docx         # Original project documentation
```

### Database

The app expects a MySQL database named **`edg`** on `localhost`, accessed as user `root` with no password by default. The connection lives in [`PHP/conn.php`](PHP/conn.php):

```php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "edg";
```

You'll need to create the `edg` database and the supporting tables (users, quizzes, questions, options, results) before the app will run. If you have a SQL dump from the original project, import it into MySQL; otherwise, create the schema based on the field names referenced in the PHP handlers.

---

## Getting started

### Prerequisites

- **PHP** 7.4+ (the project uses MySQLi, which ships with PHP)
- **MySQL** / **MariaDB**
- **Composer** (for PHPMailer)
- A local web server — any of these work:
  - **XAMPP** (recommended for Windows — bundles Apache + MySQL + PHP)
  - **WAMP** (Windows)
  - **MAMP** (macOS)
  - PHP's built-in dev server (`php -S`)

### 1. Place the project under your web root

For **XAMPP** on Windows, copy or clone the project into:

```
C:\xampp\htdocs\EDG\
```

(For WAMP it's `C:\wamp64\www\EDG\`. For MAMP on macOS it's `/Applications/MAMP/htdocs/EDG/`.)

### 2. Install Composer dependencies

From the project root:

```bash
composer install
```

This pulls in **PHPMailer**, which is used by the forgot-password flow.

### 3. Create the database

Open **phpMyAdmin** (usually at <http://localhost/phpmyadmin>) — or any MySQL client — and:

1. Create a new database called `edg`.
2. Import the project's SQL dump if you have one, or create the required tables manually.
3. If your MySQL setup uses a different user / password / host, update [`PHP/conn.php`](PHP/conn.php) accordingly.

### 4. Configure PHPMailer (optional but needed for password reset)

Open the relevant handler (`PHP/forgot_password.php`) and set the SMTP credentials for the email account that should send reset links. For Gmail you'll need an **App Password**, not your regular account password.

### 5. Start the servers and open the app

If you're using XAMPP / WAMP / MAMP, start **Apache** and **MySQL** from the control panel. Then open:

```
http://localhost/EDG/HTML/Dashboard.html
```

(or wherever you'd like to enter the flow — `Login.html` and `Signup.html` are also valid entry points).

If you prefer PHP's built-in server, from the project root:

```bash
php -S localhost:8000
```

…and visit <http://localhost:8000/HTML/Dashboard.html>.

---

## Usage walkthrough

1. **Sign up** at `Signup.html`. Client-side validation runs as you type.
2. After login, you'll be sent to **`Pick_Color.html`** — choose protanopia or tritanopia mode.
3. Then **`Pick_Size.html`** — choose a comfortable font size.
4. You land on your **User Dashboard** with access to learning content, quizzes, profile, and sample materials.
5. **Take a quiz** via `Choose_Quiz.php` → `Quiz.php` → `Quiz_Answers.php` → `Result.php`.
6. **Admin users** are routed to `Admin_Dashboard.html` instead and can manage users, quizzes, and results.

---

## Accessibility notes

- All theme colours were chosen using **colour-blindness-safe palettes** that maintain contrast for each targeted deficiency.
- Text size is user-adjustable system-wide, not page-by-page.
- Form inputs use both colour *and* text (`✓ Valid` / `✗ Invalid`) for validation feedback, so meaning is never communicated by colour alone.
- Iconography is paired with text labels wherever a control could otherwise be ambiguous.

---

## Troubleshooting

- **"Connection failed: Access denied for user 'root'@'localhost'"** — your MySQL root user has a password set. Update `PHP/conn.php` with the correct credentials.
- **"Connection failed: Unknown database 'edg'"** — you haven't created the `edg` database yet. Create it in phpMyAdmin and re-import the schema.
- **`Class 'PHPMailer\PHPMailer\PHPMailer' not found`** — run `composer install` from the project root.
- **Reset-password emails never arrive** — your SMTP credentials in `forgot_password.php` aren't correct, or your mail provider is blocking the connection. For Gmail, use an App Password and SMTP over TLS on port 587.
- **Styles look default instead of protanopia/tritanopia** — the user's accessibility profile isn't being read from the database. Make sure the `users` table has `color_mode` and `font_size` columns and that they were populated during the `Pick_Color` / `Pick_Size` flow.

---

## AI assistance

Portions of this project (debugging, refactoring, validation logic, and documentation) were developed with the help of **Claude Code** — assistance only. All architectural decisions, feature design, and the underlying code were authored and reviewed by the project owner; AI was used as a pair-programming aide, not an autonomous code generator.

---

## License

Released for **educational use only**. EDG was built as a Software Development Project to demonstrate accessible web-application design for users with colour-vision deficiencies, and is shared publicly so other students and learners can study, run, and extend it. Redistribution for commercial purposes is not permitted.
