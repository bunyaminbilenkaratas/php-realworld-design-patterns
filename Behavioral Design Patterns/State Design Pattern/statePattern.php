<?php

interface OrderState
{
    public function getName(): string;
    public function pay(Order $order): void;
    public function ship(Order $order): void;
    public function deliver(Order $order): void;
}

// --- State: Pending ---
class PendingState implements OrderState
{
    public function getName(): string
    {
        return 'pending';
    }

    public function pay(Order $order): void
    {
        $order->setState(new PaidState());
    }

    public function ship(Order $order): void
    {
        throw new Exception("Cannot ship an order that is still pending payment.");
    }

    public function deliver(Order $order): void
    {
        throw new Exception("Cannot deliver an order that hasn't been shipped.");
    }
}

// --- State: Paid ---
class PaidState implements OrderState
{
    public function getName(): string
    {
        return 'paid';
    }

    public function pay(Order $order): void
    {
        throw new Exception("Order has already been paid.");
    }

    public function ship(Order $order): void
    {
        $order->setState(new ShippedState());
    }

    public function deliver(Order $order): void
    {
        throw new Exception("Cannot deliver before the order is shipped.");
    }
}

// --- State: Shipped ---
class ShippedState implements OrderState
{
    public function getName(): string
    {
        return 'shipped';
    }

    public function pay(Order $order): void
    {
        throw new Exception("Order has already been paid and shipped.");
    }

    public function ship(Order $order): void
    {
        throw new Exception("Order is already shipped.");
    }

    public function deliver(Order $order): void
    {
        $order->setState(new DeliveredState());
    }
}

// --- State: Delivered ---
class DeliveredState implements OrderState
{
    public function getName(): string
    {
        return 'delivered';
    }

    public function pay(Order $order): void
    {
        throw new Exception("Order is already delivered.");
    }

    public function ship(Order $order): void
    {
        throw new Exception("Order is already delivered.");
    }

    public function deliver(Order $order): void
    {
        throw new Exception("Order is already delivered.");
    }
}

// --- Order Class ---
class Order
{
    private OrderState $state;

    public function __construct()
    {
        $this->state = new PendingState(); // Default starting state
        echo "Initial state: " . $this->state->getName() . "\n";
    }

    public function setState(OrderState $state): void
    {
        $this->state = $state;
        echo "State changed to: " . $this->state->getName() . "\n";
    }

    public function getState(): string
    {
        return $this->state->getName();
    }

    public function pay(): void
    {
        $this->state->pay($this);
    }

    public function ship(): void
    {
        $this->state->ship($this);
    }

    public function deliver(): void
    {
        $this->state->deliver($this);
    }
}

// --- Test Scenario ---
try {
    $order = new Order();

    $order->pay();       // pending -> paid
    $order->ship();      // paid -> shipped
    $order->deliver();   // shipped -> delivered

    echo "Final state: " . $order->getState() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
