<?php
$receiving_email_address = 'buddhichanuka@gmail.com';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
        include($php_email_form);
    } else {
        die('Unable to load the "PHP Email Form" Library!');
    }

    $contact = new PHP_Email_Form;
    $contact->ajax = true;

    $contact->to = $receiving_email_address;
    $contact->from_name = $_POST['name'];
    $contact->from_email = $_POST['email'];
    $contact->subject = $_POST['subject'];

    $contact->add_message($_POST['name'], 'From');
    $contact->add_message($_POST['email'], 'Email');
    $contact->add_message($_POST['message'], 'Message', 10);

    $headers = 'From: ' . $contact->from_name . '<' . $contact->from_email . '>' . "\r\n" .
        'Reply-To: ' . $contact->from_email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $message = '';
    foreach ($contact->message as $m) {
        $message .= $m['label'] . ": " . $m['content'] . "\n";
    }

    $mail_success = mail($contact->to, $contact->subject, $message, $headers);

    if ($mail_success) {
        echo json_encode(array('success' => true, 'message' => 'Your message has been sent. Thank you!'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Failed to send the message. Please try again later.'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request.'));
}
?>
