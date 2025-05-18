<?php

interface MediatorInterface
{
    public function notify(object $sender, string $event): void;
}

class OrderService {
    public function createOrder() {
        echo "Order created.\n";
    }
}

class PaymentService {
    public function processPayment() {
        echo "Payment processed.\n";
    }
}

class InvoiceService {
    public function generateInvoice() {
        echo "Invoice generated.\n";
    }
}

class ShippingService {
    public function notifyShippingCompany() {
        echo "Shipping company notified.\n";
    }
}

class EcommerceMediator implements MediatorInterface {
    public function __construct(
        protected OrderService $orderService,
        protected PaymentService $paymentService,
        protected InvoiceService $invoiceService,
        protected ShippingService $shippingService
    ) {}

    public function notify(object $sender, string $event): void
    {
        if ($event === 'order_placed') {
            $this->orderService->createOrder();
            $this->paymentService->processPayment();
            $this->invoiceService->generateInvoice();
            $this->shippingService->notifyShippingCompany();
        }
    }
}

class EcommerceController {
    public function __construct(
        protected EcommerceMediator $mediator
    ) {}

    public function checkout() {
        $this->mediator->notify($this, 'order_placed');
    }
}

// Usage
$mediator = new EcommerceMediator(
    new OrderService(),
    new PaymentService(),
    new InvoiceService(),
    new ShippingService()
);

$controller = new EcommerceController($mediator);
$controller->checkout();
