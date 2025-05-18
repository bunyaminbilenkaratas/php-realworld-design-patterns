<?php

interface MenuComponent {
    public function render($indent = 0);
}

class MenuItem implements MenuComponent {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function render($indent = 0) {
        echo str_repeat(" ", $indent) . "- " . $this->name . PHP_EOL;
    }
}

class Menu implements MenuComponent {
    private $name;
    private $components = [];

    public function __construct($name) {
        $this->name = $name;
    }

    public function add(MenuComponent $component) {
        $this->components[] = $component;
    }

    public function render($indent = 0) {
        echo str_repeat(" ", $indent) . "+ " . $this->name . PHP_EOL;
        foreach ($this->components as $component) {
            $component->render($indent + 2);
        }
    }
}

//Usage
$mainMenu = new Menu("Main Menu");
$mainMenu->add(new MenuItem("Home"));
$mainMenu->add(new MenuItem("About"));

$servicesMenu = new Menu("Services");
$servicesMenu->add(new MenuItem("Web Development"));
$servicesMenu->add(new MenuItem("SEO"));

$mainMenu->add($servicesMenu);
$mainMenu->add(new MenuItem("Contact"));

$mainMenu->render();
