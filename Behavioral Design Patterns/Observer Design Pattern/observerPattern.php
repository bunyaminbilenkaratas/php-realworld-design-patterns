<?php

class Database {
    private $products = [
        ['id' => 1, 'name' => 'Computer', 'price' => 100, 'stock' => 10],
        ['id' => 2, 'name' => 'Phone', 'price' => 200, 'stock' => 5],
        ['id' => 3, 'name' => 'USB Charger', 'price' => 300, 'stock' => 0],
    ];

    public function getProduct($id) {
        foreach ($this->products as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
        return null;
    }

    public function updateProductStock($id, $newStock) {
        foreach ($this->products as &$product) {
            if ($product['id'] == $id) {
                $product['stock'] = $newStock;
                echo "Stock updated for product ID {$id}: New Stock is {$newStock}\n";
                return true;
            }
        }
        return false;
    }
}

interface Observer {
    public function update($eventData);
}

class UpdateStockObserver implements Observer {
    private $database;
    public function __construct($database) {
        $this->database = $database;
    }

    public function update($eventData) {
        $product = $this->database->getProduct($eventData['productId']);
        if ($product) {
            $newStock = $product['stock'] - $eventData['quantity'];
            $this->database->updateProductStock($eventData['productId'], $newStock);
        }
    }
}

class OrderLogObserver implements Observer {
    public function update($eventData) {
        echo "Order Log: Product ID {$eventData['productId']} ordered with quantity {$eventData['quantity']}\n";
    }
}

class Order {
    private $observers = [];
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer) {
        foreach ($this->observers as $key => $value) {
            if ($value === $observer) {
                unset($this->observers[$key]);
            }
        }
    }

    public function notify($eventData) {
        foreach ($this->observers as $observer) {
            $observer->update($eventData);
        }
    }

    public function createOrder($orderId, $productId, $quantity) {
        $this->notify([
            'orderId' => $orderId,
            'productId' => $productId,
            'quantity' => $quantity
        ]);
    }
}

// Usage
$database = new Database();
$order = new Order($database);

$updateStockObserver = new UpdateStockObserver($database);
$orderLogObserver = new OrderLogObserver();

$order->attach($updateStockObserver);
$order->attach($orderLogObserver);

$order->createOrder(1, 1, 2);
