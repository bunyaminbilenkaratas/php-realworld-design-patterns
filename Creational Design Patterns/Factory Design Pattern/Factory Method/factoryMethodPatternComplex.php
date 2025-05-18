<?php

class PaymentLogger {
    public function log($message)
    {
        echo "[LOG]: $message\n";
    }
}

class PaymentNotifier {
    public function notify($message)
    {
        echo "[NOTIFICATION]: $message\n";
    }
}

abstract class Payment {
    protected $logger;
    protected $notifier;

    public function __construct(PaymentLogger $logger, PaymentNotifier $notifier)
    {
        $this->logger = $logger;
        $this->notifier = $notifier;
    }

    public function processPayment()
    {
        $this->logger->log('Payment processed successfully');
        $this->validate();
        $this->process();
        $this->sendReceipt();
        $this->notifier->notify('Payment processed successfully');
    }

    abstract protected function validate();
    abstract protected function process();
    protected function sendReceipt()
    {
       $this->notifier->notify('Receipt sent');
    }
}

class CreditCardPayment extends Payment
{
    protected function validate()
    {
        $this->logger->log('Credit card validated');
    }

    protected function process()
    {
        $this->logger->log('Credit card processed');
    }
}

class PaypalPayment extends Payment
{
    protected function validate()
    {
        $this->logger->log('Paypal validated');
    }

    protected function process()
    {
        $this->logger->log('Paypal processed');
    }
}

abstract class PaymentFactory
{
    abstract public function createPayment(): Payment;
}

class CreditCardPaymentFactory extends PaymentFactory
{
    public function createPayment(): Payment
    {
        return new CreditCardPayment(new PaymentLogger(), new PaymentNotifier());
    }
}

class PaypalPaymentFactory extends PaymentFactory
{
    public function createPayment(): Payment
    {
        return new PaypalPayment(new PaymentLogger(), new PaymentNotifier());
    }
}

//Usage
$paypalFactory = new PaypalPaymentFactory();
$paypalPayment = $paypalFactory->createPayment();
$paypalPayment->processPayment();
