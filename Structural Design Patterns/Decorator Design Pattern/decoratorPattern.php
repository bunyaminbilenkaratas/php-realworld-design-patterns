<?php

class Cart {
    private $items = [];

    public function addItem($item) {
        $this->items[] = $item;
    }

    public function getTotal() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getPrice();
        }
        return $total;
    }
}

class Product {
    private $name;
    private $price;

    public function __construct($name, $price) {
        $this->name = $name;
        $this->price = $price;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getName() {
        return $this->name;
    }
}

abstract class CartDecorator {
    protected $cart;

    public function __construct($cart) {
        $this->cart = $cart;
    }

    abstract public function getTotal();
}

class StudentDiscountDecorator extends CartDecorator {
    public function getTotal()
    {
        $total = $this->cart->getTotal();
        return $total * 0.9; // 10% discount for students
    }
}

class PromoCodeDiscountDecorator extends CartDecorator {

    public function getTotal()
    {
        $total = $this->cart->getTotal();
        return $total * 0.8; // 20% discount for promo code
    }
}

class FreeShippingDecorator extends CartDecorator {
    public function getTotal()
    {
        $total = $this->cart->getTotal();
        if ($total > 100) {
            return $total; // Free shipping for orders over $100
        }
        return $total + 10; // $10 shipping fee for orders under $100
    }
}

//Usage
$cart = new Cart();
$cart->addItem(new Product("Product 1", 50));
$cart->addItem(new Product("Product 2", 60));

$cartWithStudentDiscount = new StudentDiscountDecorator($cart);
$cartWithStudentDiscountAndPromoCode = new PromoCodeDiscountDecorator($cartWithStudentDiscount);
$cartWithAllDiscounts = new FreeShippingDecorator($cartWithStudentDiscountAndPromoCode);

echo "Total with Free Shipping: " . $cartWithAllDiscounts->getTotal() . "\n";
