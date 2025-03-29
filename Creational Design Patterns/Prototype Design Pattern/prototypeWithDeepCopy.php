<?php

class Product {
    private $name;
    private $price;

    public function __construct(string $name, float $price) {
        $this->name = $name;
        $this->price = $price;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setPrice(float $price): void {
        $this->price = $price;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPrice(): float {
        return $this->price;
    }
}

class Cart {
    private $products = [];

    public function addProduct(Product $product): void {
        $this->products[] = $product;
    }

    public function getProducts(): array {
        return $this->products;
    }

    // '__clone() Magic method for deep copy.'
    public function __clone() {
        $newProducts = [];
        foreach ($this->products as $product) {
            //Create a new object for each product
            $newProducts[] = new Product($product->getName(), $product->getPrice());
        }
        $this->products = $newProducts;
    }

    public function display(): string {
        $output = "Cart Contents:\n";
        foreach ($this->products as $product) {
            $output .= "- {$product->getName()} (\${$product->getPrice()})\n";
        }
        return $output;
    }
}

// Usage for multi-cart shopping site example
$originalCart = new Cart();
$originalCart->addProduct(new Product("Laptop", 1200));
$originalCart->addProduct(new Product("Mouse", 25));

$clonedCart = clone $originalCart;

$clonedCart->addProduct(new Product("Keyboard", 50));

echo "Original Cart:\n";
echo $originalCart->display();

echo "\nCloned Cart:\n";
echo $clonedCart->display();
