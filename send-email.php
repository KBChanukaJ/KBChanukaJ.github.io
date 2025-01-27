<?php
session_start();

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect and sanitize form data
    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars($_POST["message"]);

    // Validate required fields
    if (empty($name) || !$email || empty($message)) {
        $_SESSION['status'] = "All fields are required. Please fill out the form completely.";
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit;
    }

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'buddhichanuka@gmail.com'; // Your SMTP username (email)
        $mail->Password = 'qdva bhgv awdh poyr'; // Your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Set sender and recipient details
        $mail->setFrom('buddhichanuka@gmail.com', 'Personal Website');
        $mail->addAddress('buddhichanuka@gmail.com'); // Recipient email

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'New Message from Contact Form';
        $mail->Body = "
            <h3>Contact Form Submission</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Message:</strong></p>
            <p>$message</p>
        ";

        // Send email and set session status
        if ($mail->send()) {
            $_SESSION['status'] = "Thank you for contacting us. Your message has been sent successfully.";
        } else {
            $_SESSION['status'] = "Sorry, your message could not be sent. Please try again later.";
        }

    } catch (Exception $e) {
        // Handle PHPMailer exceptions
        $_SESSION['status'] = "An error occurred while sending the message. Error: {$mail->ErrorInfo}";
    }

    // Redirect back to the previous page with a session status
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit;

} else {
    // Redirect to index.html if accessed without form submission
    header("Location: index.html");
    exit;
}
?>
