<?php

abstract class Singleton {
    // Each subclass should ideally have its own instance.
    // (Note: To avoid sharing the instance among all children, each child could declare its own protected static $instance.)
    protected static $instance;

    // Protected constructor prevents direct instantiation.
    protected function __construct() { }

    // Prevent cloning.
    private function __clone() { }

    // Prevent unserialization.
    public function __wakeup() {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}

class Logger extends Singleton
{
    public function log(string $message)
    {
        echo $message . PHP_EOL;
    }
}

$logger = Logger::getInstance();
$logger->log("System loaded !");