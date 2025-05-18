<?php

class HeavyObject {
    public $result;

    public function __construct() {
        echo "Constructor working...\n";
        sleep(3); // A heavy process that takes 3 sec.
        $this->result = "Calculated!";
    }
}

echo "Creation with new keyword:\n";
$start = microtime(true);
$obj1 = new HeavyObject(); // '__construct()' works.
$end = microtime(true);
echo "Time: " . round($end - $start, 2) . " sec\n\n";

echo "Creation with clone:\n";
$start = microtime(true);
$obj2 = clone $obj1; // '__construct()' does not work again.
$end = microtime(true);
echo "Time: " . round($end - $start, 2) . " sec\n";
