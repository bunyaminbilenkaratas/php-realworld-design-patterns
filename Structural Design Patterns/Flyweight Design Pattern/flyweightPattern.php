<?php

class FontStyle
{
    public $font;
    public $size;
    public $bold;
    public $italic;

    public function __construct($font, $size, $bold, $italic)
    {
        $this->font = $font;
        $this->size = $size;
        $this->bold = $bold;
        $this->italic = $italic;
    }

    public function describe()
    {
        return "Font: {$this->font}, Size: {$this->size}, Bold: {$this->bold}, Italic: {$this->italic}";
    }
}

class FontStyleFactory
{
    private static $styles = []; // static property to store styles

    public static function getStyle($font, $size, $bold, $italic)
    {
        $key = md5($font . $size . $bold . $italic);

        if (!isset(self::$styles[$key])) {
            self::$styles[$key] = new FontStyle($font, $size, $bold, $italic);
        }

        return self::$styles[$key];
    }
}

class Character
{
    public $char;
    public $x;
    public $y;
    private $style; // flyweight object

    public function __construct($char, $x, $y, FontStyle $style)
    {
        $this->char = $char;
        $this->x = $x;
        $this->y = $y;
        $this->style = $style;
    }

    public function render()
    {
        echo "Rendering character '{$this->char}' at ({$this->x}, {$this->y}) with {$this->style->describe()}\n";
    }
}

// usage

$doc = [];

$style1 = FontStyleFactory::getStyle("Arial", 12, true, false);
$style2 = FontStyleFactory::getStyle("Times New Roman", 14, false, true);

$doc[] = new Character("H", 0, 0, $style1);
$doc[] = new Character("e", 10, 0, $style1);
$doc[] = new Character("l", 20, 0, $style1);
$doc[] = new Character("l", 30, 0, $style1);
$doc[] = new Character("o", 40, 0, $style2);

foreach ($doc as $char) {
    $char->render();
}
