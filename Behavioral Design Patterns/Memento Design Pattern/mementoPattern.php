<?php

class BlogPost {
    private string $title;
    private string $content;

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setContent(string $content): void {
        $this->content = $content;
    }

    public function show(): void {
        echo "Title: " . $this->title . "\n";
        echo "Content: " . $this->content . "\n";
    }

    public function save(): BlogPostMemento {
        return new BlogPostMemento($this->title, $this->content);
    }

    public function restore(BlogPostMemento $memento): void {
        $this->title = $memento->getTitle();
        $this->content = $memento->getContent();
    }
}

class BlogPostMemento {
    private string $title;
    private string $content;

    public function __construct(string $title, string $content) {
        $this->title = $title;
        $this->content = $content;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getContent(): string {
        return $this->content;
    }
}

// Caretaker
class BlogHistory {
    private array $history = [];

    public function saveMemento(BlogPostMemento $memento): void {
        $this->history[] = $memento;
    }

    public function undo(): ?BlogPostMemento {
        if (empty($this->history)) {
            return null;
        }
        return array_pop($this->history);
    }
}

// Usage

$post = new BlogPost();
$history = new BlogHistory();

$post->setTitle("My First Blog Post");
$post->setContent("This is the content of my first blog post.");
$history->saveMemento($post->save());

$post->setContent("This is the updated content of my first blog post.");
$history->saveMemento($post->save());

$post->setContent("This is the final content of my first blog post.");
$post->show();

$memento = $history->undo();
if ($memento) {
    $post->restore($memento);
    echo "After undo:\n";
    $post->show();
} else {
    echo "No history to undo.\n";
}
