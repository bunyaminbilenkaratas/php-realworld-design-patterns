<?php

class FileCache {
    public function set($key, $value) {
        file_put_contents(__DIR__ . "/cache_$key.txt", $value);
    }

    public function get($key) {
        if (file_exists(__DIR__ . "/cache_$key.txt")) {
            return file_get_contents(__DIR__ . "/cache_$key.txt");
        }
        return null;
    }
}

class MemoryCache {
    private static $store = [];

    public function set($key, $value) {
        self::$store[$key] = $value;
    }

    public function get($key) {
        return self::$store[$key] ?? null;
    }
}

class CacheFacade {
    private static $driver;

    public static function useFileDriver() {
        self::$driver = new FileCache();
    }

    public static function useMemoryDriver() {
        self::$driver = new MemoryCache();
    }

    public static function set($key, $value) {
        self::$driver->set($key, $value);
    }

    public static function get($key) {
        return self::$driver->get($key);
    }
}

//Usage
CacheFacade::useFileDriver();
CacheFacade::set('name', 'John Doe');
echo CacheFacade::get('name') . PHP_EOL;

CacheFacade::useMemoryDriver();
CacheFacade::set('name', 'Adam Cruise');
echo CacheFacade::get('name') . PHP_EOL;
