<?php

interface Command {
    public function execute(): void;
    public function undo(): void;
}

class DeleteFileCommand implements Command {
    private $file;
    private $filePath;

    public function __construct($filePath) {
        $this->filePath = $filePath;
        $this->file = null;
    }

    public function execute(): void {
        if (file_exists($this->filePath)) {
            $this->file = file_get_contents($this->filePath);
            unlink($this->filePath);
            echo "File deleted: " . $this->filePath . "\n";
        } else {
            echo "File not found: " . $this->filePath . "\n";
        }
    }

    public function undo(): void {
        if ($this->filePath) {
            file_put_contents($this->filePath, $this->file);
            echo "File restored: " . $this->filePath . "\n";
        } else {
            echo "No file to restore.\n";
        }
    }
}

class CopyFileCommand implements Command {
    private $sourcePath;
    private $destinationPath;

    public function __construct($sourcePath, $destinationPath) {
        $this->sourcePath = $sourcePath;
        $this->destinationPath = $destinationPath;
    }

    public function execute(): void {
        if (file_exists($this->sourcePath)) {
            copy($this->sourcePath, $this->destinationPath);
            echo "File copied from " . $this->sourcePath . " to " . $this->destinationPath . "\n";
        } else {
            echo "Source file not found: " . $this->sourcePath . "\n";
        }
    }

    public function undo(): void {
        if (file_exists($this->destinationPath)) {
            unlink($this->destinationPath);
            echo "File deleted: " . $this->destinationPath . "\n";
        } else {
            echo "Destination file not found: " . $this->destinationPath . "\n";
        }
    }
}

class MoveFileCommand implements Command {
    private $sourcePath;
    private $destinationPath;

    public function __construct($sourcePath, $destinationPath) {
        $this->sourcePath = $sourcePath;
        $this->destinationPath = $destinationPath;
    }

    public function execute(): void {
        if (file_exists($this->sourcePath)) {
            rename($this->sourcePath, $this->destinationPath);
            echo "File moved from " . $this->sourcePath . " to " . $this->destinationPath . "\n";
        } else {
            echo "Source file not found: " . $this->sourcePath . "\n";
        }
    }

    public function undo(): void {
        if (file_exists($this->destinationPath)) {
            rename($this->destinationPath, $this->sourcePath);
            echo "File moved back from " . $this->destinationPath . " to " . $this->sourcePath . "\n";
        } else {
            echo "Destination file not found: " . $this->destinationPath . "\n";
        }
    }
}

class FileManager
{
    private $commands = [];
    private $undoStack = [];

    public function addCommand(Command $command): void {
        $this->commands[] = $command;
    }

    public function executeCommands(): void {
        foreach ($this->commands as $command) {
            $command->execute();
            $this->undoStack[] = $command;
        }
    }

    public function undoLastCommand(): void {
        if (!empty($this->undoStack)) {
            $command = array_pop($this->undoStack);
            $command->undo();
        } else {
            echo "No commands to undo.\n";
        }
    }
}

// Usage
$fileManager = new FileManager();

$fileManager->addCommand(new DeleteFileCommand('test.txt'));
$fileManager->addCommand(new CopyFileCommand('source.txt', 'destination.txt'));
$fileManager->addCommand(new MoveFileCommand('old_location.txt', 'new_location.txt'));

$fileManager->executeCommands();

$fileManager->undoLastCommand();
$fileManager->undoLastCommand();
$fileManager->undoLastCommand();
