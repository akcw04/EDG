
<?php

session_start();
unset($_SESSION['User_id']);

require 'C:/xampp/htdocs/EDG/vendor/autoload.php';

include 'conn.php';


function check_data($email, $conn) {
    $stmt = $conn->prepare("SELECT User_id FROM users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $_SESSION['User_id'] = $user['User_id'];
        sendResetEmail($email);
    } else {
        echo '<script class="alert" >alert("No Such Record Found"); window.location.href = "http://localhost/EDG/HTML/Forgot_Password.html";</script>';
    }
    $stmt->close();
}

if (isset($_POST['submit']) && isset($_POST['email'])) {
    check_data($_POST['email'], $conn);
}



function sendResetEmail($email) {
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        putenv('GMAIL_USERNAME=akcw04ju@gmail.com');
        putenv('GMAIL_APP_PASSWORD=acjy dylh wceh qjaz');
        $mail->Username = getenv('GMAIL_USERNAME');
        $mail->Password = getenv('GMAIL_APP_PASSWORD');
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('akcw04ju@gmail.com', 'Web Admin');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Reset Your Password';
        $mail->Body    = 'Please click on the following link to reset your password: <a href="https://localhost/EDG/HTML/Reset_Password.html">Reset Password</a>';
        $mail->AltBody = 'Please click on the following link to reset your password: https://localhost/EDG/HTML/Reset_Password.html<br>This Link Will Expire in 60 seconds';

        $mail->send();
        echo '<script>alert("Reset Email Has been Sent To Your Mailbox, You can Close this Window Now")</script>';
    } catch (Exception $e) {
        echo '<script>alert("Mail Could Not be Sent, Error: ")</script>' . $mail->ErrorInfo;
    }
}

