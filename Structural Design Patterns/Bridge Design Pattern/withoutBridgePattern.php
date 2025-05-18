<?php

class Notification {
    private $message;
    private $type;

    public function __construct($message, $type) {
        $this->message = $message;
        $this->type = $type;
    }

    public function send() {
        if ($this->type == 'email') {
            echo "Sending email notification: " . $this->message . "\n";
        } elseif ($this->type == 'sms') {
            echo "Sending SMS notification: " . $this->message . "\n";
        } else {
            echo "Unknown notification type." . "\n";
        }
    }
}

// Usage
$notification1 = new Notification("Hello, this is an email!", "email");
$notification1->send();

$notification2 = new Notification("Hello, this is an SMS!", "sms");
$notification2->send();
