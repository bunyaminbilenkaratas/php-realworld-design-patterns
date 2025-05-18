<?php

abstract class Payment
{
    abstract public function process();
}

class CreditCardPayment extends Payment
{
    public function process()
    {
        echo "Processing credit card payment";
    }
}

class PaypalPayment extends Payment
{
    public function process()
    {
        echo "Processing paypal payment";
    }
}

abstract class PaymentFactory
{
    abstract public function createPayment();
}

class CreditCardFactory extends PaymentFactory
{
    public function createPayment()
    {
        return new CreditCardPayment();
    }
}

class PaypalFactory extends PaymentFactory
{
    public function createPayment()
    {
        return new PaypalPayment();
    }
}

//Usage
$paymentFactory = new PaypalFactory();
$paymentFactory->createPayment()->process();
