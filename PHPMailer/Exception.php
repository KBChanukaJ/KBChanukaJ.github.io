<?php
namespace PHPMailer\PHPMailer;

class Exception extends \Exception
{
    // Your class implementation goes here
    // You should include all methods and properties of the actual Exception class

    // Example properties:
    protected $error_message;

    // Example methods:
    public function errorMessage() {
        return $this->error_message;
    }

    // Other methods and properties go here...
}
?>
