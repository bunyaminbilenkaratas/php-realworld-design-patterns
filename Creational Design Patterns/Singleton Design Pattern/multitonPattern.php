<?php

class Singleton {
    private static $instances = [];

    // Protected constructor allows subclassing.
    protected function __construct() { }

    // Prevent cloning.
    protected function __clone() { }

    // Prevent unserialization.
    public function __wakeup() {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance() {
        $subclass = static::class;
        if (!isset(self::$instances[$subclass])) {
            self::$instances[$subclass] = new static();
        }
        return self::$instances[$subclass];
    }
}

class Logger extends Singleton
{
    public function log(string $message)
    {
        echo $message . PHP_EOL;
    }
}

class Cache extends Singleton
{
    private $settings = [];
    public function get(string $key)
    {
        return $this->settings[$key] ?? null;
    }

    public function set(string $key, string $value)
    {
        $this->settings[$key] = $value;
    }

    public function forget(string $key)
    {
        unset($this->settings[$key]);
    }
}

// Usage:
$logger = Logger::getInstance();
$logger->log("System files loaded !");

$cache = Cache::getInstance();
$cache->set("email", "bunyaminbilenkaratas@gmail.com");

echo "Email: " . $cache->get("email") . PHP_EOL;
$cache->forget("email");
echo "Email deleted " . $cache->get("email") . PHP_EOL;
