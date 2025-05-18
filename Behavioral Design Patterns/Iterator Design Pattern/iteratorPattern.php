<?php

class Book {
    private $title;
    private $author;

    public function __construct($title, $author) {
        $this->title = $title;
        $this->author = $author;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }
}

interface IteratorInterface {
    public function next();
    public function valid();
    public function current();
    public function rewind();
}

interface CollectionInterface {
    public function getIterator();
}

class BookCollection implements CollectionInterface {
    private $books = [];

    public function addBook(Book $book) {
        $this->books[] = $book;
    }

    public function getIterator() {
        return new BookIterator($this->books);
    }
}

class BookIterator implements IteratorInterface {
    private $books;
    private $index = 0;

    public function __construct($books) {
        $this->books = $books;
    }

    public function next() {
        return $this->index++;
    }

    public function valid() {
        return isset($this->books[$this->index]);
    }

    public function current() {
        return $this->books[$this->index];
    }

    public function rewind() {
        $this->index = 0;
    }
}

// Usage
$book1 = new Book("1984", "George Orwell");
$book2 = new Book("To Kill a Mockingbird", "Harper Lee");
$book3 = new Book("The Great Gatsby", "F. Scott Fitzgerald");

$collection = new BookCollection();
$collection->addBook($book1);
$collection->addBook($book2);
$collection->addBook($book3);

$iterator = $collection->getIterator();
while ($iterator->valid()) {
    $book = $iterator->current();
    echo "Title: " . $book->getTitle() . ", Author: " . $book->getAuthor() . PHP_EOL;
    $iterator->next();
}
