<?php

class Caracter {
    public $char;
    public $x;
    public $y;
    public $font;
    public $size;
    public $bold;
    public $italic;

    public function __construct($char, $x, $y, $font, $size, $bold, $italic) {
        $this->char = $char;
        $this->x = $x;
        $this->y = $y;
        $this->font = $font;
        $this->size = $size;
        $this->bold = $bold;
        $this->italic = $italic;
    }

    public function render()
    {
        echo "Rendering character '{$this->char}' at ({$this->x}, {$this->y}) with font '{$this->font}', size {$this->size}, bold: {$this->bold}, italic: {$this->italic}\n";
    }
}

// Usage
$char1 = new Caracter('A', 10, 20, 'Arial', 12, true, false);
$char2 = new Caracter('B', 30, 40, 'Arial', 12, true, false);
$char3 = new Caracter('C', 50, 60, 'Arial', 12, true, true);
$char1->render();
$char2->render();
$char3->render();
