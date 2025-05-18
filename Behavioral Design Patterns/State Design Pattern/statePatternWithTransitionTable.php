<?php

class Order
{
    private string $state;

    private const TRANSITION_TABLE = [
        'pending' => ['paid'],
        'paid' => ['shipped'],
        'shipped' => ['delivered'],
        'delivered' => [],
    ];

    public function __construct(string $initialState = 'pending')
    {
        if (!isset(self::TRANSITION_TABLE[$initialState])) {
            throw new Exception("Invalid initial state: $initialState");
        }
        $this->state = $initialState;
        echo "Initial state: $this->state\n";
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function canTransitionTo(string $newState): bool
    {
        return in_array($newState, self::TRANSITION_TABLE[$this->state]);
    }

    public function transitionTo(string $newState): void
    {
        if (!$this->canTransitionTo($newState)) {
            throw new Exception("Invalid transition from {$this->state} to $newState");
        }

        $this->state = $newState;
        echo "Transitioned to: $this->state\n";
    }
}

// --- Usage ---
try {
    $order = new Order();

    $order->transitionTo('paid');      // pending -> paid
    $order->transitionTo('shipped');   // paid -> shipped
    $order->transitionTo('delivered'); // shipped -> delivered

    echo "Final state: " . $order->getState() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
