<?php

interface FileInterface {
    public function readFile();
}

class RealFile implements FileInterface {
    public function readFile() {
        return "File Content" . PHP_EOL;
    }
}

class SecureFileProxy implements FileInterface {
    private RealFile $realFile;
    private $userRole;

    public function __construct($userRole) {
        $this->userRole = $userRole;
        $this->realFile = new RealFile();
    }

    public function readFile() {
        if ($this->userRole === 'admin') {
            return $this->realFile->readFile();
        } else {
            return "Access Denied" . PHP_EOL;
        }
    }
}

// Usage
$file = new SecureFileProxy('bunyamin');
echo $file->readFile();

$file = new SecureFileProxy('admin');
echo $file->readFile();
