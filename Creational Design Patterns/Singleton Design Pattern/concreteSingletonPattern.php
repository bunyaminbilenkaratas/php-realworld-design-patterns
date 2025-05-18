<?php

/*
 * A “Concrete Singleton” is a class that implements the singleton pattern by itself without relying on an external base class.
 * For example, a Logger class written in singleton form on its own.
 */

class Logger {
    private static $instance = null;

    // Private constructor to prevent direct instantiation.
    private function __construct() { }

    // Prevent cloning.
    private function __clone() { }

    // Prevent unserialization.
    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton.");
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function log(string $message) {
        echo $message . PHP_EOL;
    }
}

$logger = Logger::getInstance();
$logger->log("System started !");
