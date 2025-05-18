<?php

interface NotificationSender {
    public function sendMessage(string $recipient, string $message): bool;
}

class EmailSender implements NotificationSender {
    public function sendMessage(string $recipient, string $message): bool {
        echo "Email sent to $recipient: $message\n";
        return true;
    }
}

class SMSSender implements NotificationSender {
    public function sendMessage(string $recipient, string $message): bool {
        echo "SMS sent to $recipient: $message\n";
        return true;
    }
}

// Notification Abstraction

class Notification {
    protected NotificationSender $sender;
    protected string $recipient;

    public function __construct(NotificationSender $sender, string $recipient) {
        $this->sender = $sender;
        $this->recipient = $recipient;
    }

    public function send(string $message): void {
        echo "Sending notification...\n";
        $result = $this->sender->sendMessage($this->recipient, $message);
        if ($result) {
            echo "Notification sent successfully.\n";
        } else {
            echo "Failed to send notification.\n";
        }
    }
}

// Client Code
$emailSender = new EmailSender();
$emailNotification = new Notification($emailSender, "example@mail.com");
$emailNotification->send("Hello via Email!");

$smsSender = new SMSSender();
$smsNotification = new Notification($smsSender, "1234567890");
$smsNotification->send("Hello via SMS!");