<?php

class PHP_Email_Form
{
    public $to;
    public $from_name;
    public $from_email;
    public $subject;
    public $smtp;
    public $ajax;
    public $message = array();

    public function add_message($content, $label, $label_padding = false)
    {
        $this->message[] = array('content' => $content, 'label' => $label, 'label_padding' => $label_padding);
    }

    public function send()
{
    $headers = 'From: ' . $this->from_name . ' <' . $this->from_email . '>' . "\r\n" .
        'Reply-To: ' . $this->from_email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $message = '';
    foreach ($this->message as $m) {
        $message .= $m['label'] . ": " . $m['content'] . "\n";
    }

    // Additional headers for better email handling (optional)
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/plain;charset=UTF-8" . "\r\n";

    // Send email
    $mail_success = mail($this->to, $this->subject, $message, $headers);

    if ($mail_success) {
        return json_encode(array('success' => true, 'message' => 'Email sent successfully.'));
    } else {
        return json_encode(array('success' => false, 'message' => 'Failed to send email.'));
    }
}

}
