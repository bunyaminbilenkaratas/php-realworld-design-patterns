<?php

interface FileSystemVisitor {
    public function visitFile(File $file);
    public function visitFolder(Folder $folder);
    public function visitLink(Link $link);
}

interface FileSystemElement {
    public function accept(FileSystemVisitor $visitor);
}

class File implements FileSystemElement {
    public string $name;
    public int $size;

    public function __construct(string $name, int $size) {
        $this->name = $name;
        $this->size = $size;
    }

    public function accept(FileSystemVisitor $visitor) {
        $visitor->visitFile($this);
    }
}

class Folder implements FileSystemElement {
    public string $name;
    public array $children = [];

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function add(FileSystemElement $element) {
        $this->children[] = $element;
    }

    public function accept(FileSystemVisitor $visitor) {
        $visitor->visitFolder($this);
    }
}

class Link implements FileSystemElement {
    public string $name;
    public FileSystemElement $target;

    public function __construct(string $name, FileSystemElement $target) {
        $this->name = $name;
        $this->target = $target;
    }

    public function accept(FileSystemVisitor $visitor) {
        $visitor->visitLink($this);
    }
}

class SizeCalculator implements FileSystemVisitor {
    public int $totalSize = 0;

    public function visitFile(File $file) {
        $this->totalSize += $file->size;
    }

    public function visitFolder(Folder $folder) {
        foreach ($folder->children as $child) {
            $child->accept($this);
        }
    }

    public function visitLink(Link $link) {
    }
}

class StructurePrinter implements FileSystemVisitor {
    private int $depth = 0;

    public function visitFile(File $file) {
        echo str_repeat('  ', $this->depth) . "📄 " . $file->name . "\n";
    }

    public function visitFolder(Folder $folder) {
        echo str_repeat('  ', $this->depth) . "📁 " . $folder->name . "\n";
        $this->depth++;
        foreach ($folder->children as $child) {
            $child->accept($this);
        }
        $this->depth--;
    }

    public function visitLink(Link $link) {
        echo str_repeat('  ', $this->depth) . "🔗 " . $link->name . " → " . $link->target->name . "\n";
    }
}

$root = new Folder('root');
$file1 = new File('readme.txt', 100);
$file2 = new File('logo.png', 300);
$subFolder = new Folder('docs');
$subFolder->add(new File('manual.pdf', 500));
$link = new Link('shortcut', $file1);
$root->add($file1);
$root->add($file2);
$root->add($subFolder);
$root->add($link);

$sizeVisitor = new SizeCalculator();
$root->accept($sizeVisitor);
echo "Total Size: {$sizeVisitor->totalSize} KB\n\n";

$printVisitor = new StructurePrinter();
$root->accept($printVisitor);
