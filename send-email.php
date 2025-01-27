<?php
session_start();

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitButton'])) {

    // Collect form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'buddhichanuka@gmail.com'; // SMTP username
        $mail->Password = 'qdva bhgv awdh poyr'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Set sender and recipient details
        $mail->setFrom('buddhichanuka@gmail.com', 'From the Personal Web');
        $mail->addAddress('buddhichanuka@gmail.com'); // Add recipient

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Mail To FindJob Team';
        $mail->Body = "<h3>Name: $name <br> Email: $email <br> Phone: $phone <br> Message: $message </h3>";

        // Send email and redirect with a success message
        if ($mail->send()) {
            $_SESSION['status'] = "Thank you for contacting us - Team FindJob";
        } else {
            $_SESSION['status'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    } catch (Exception $e) {
        // Handle PHPMailer exception and display error
        $_SESSION['status'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    // Redirect back to the previous page
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit;

} else {
    // Redirect to index.html if accessed directly without form submission
    header("Location: index.html");
    exit;
}
