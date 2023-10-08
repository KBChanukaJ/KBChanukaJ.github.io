<?php
$name = $_POST['name'];
$email = $_POST['email'];
$msg = $_POST['message'];

$to = 'buddhichanuka@gmail.com';
$subject = 'Email from Contact Form';
$message = 'Name: '.$name. "\r\n". 'Email: '.$email. "\r\n".'Message: '. $msg;
$headers = 'From: '. $name . '<example@example.com>'. "\r\n" . 'Reply-To: '.$email . "\r\n". 'X-Mailer: PHP/'.phpversion();

if(mail($to, $subject, $message, $headers)) {
    echo 'Email Sent Successfully';
} else {
    echo 'Email Failure';
}
?>
