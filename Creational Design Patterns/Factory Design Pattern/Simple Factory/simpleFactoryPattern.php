<?php
class Payment
{
    public function process()
    {
        echo "Processing payment";
    }
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

class PaymentFactory
{
    public static function createPayment($type)
    {
        switch ($type) {
            case 'credit_card':
                return new CreditCardPayment();
            case 'paypal':
                return new PaypalPayment();
            default:
                throw new Exception("Payment method not supported");
        }
    }
}

//Usage
$paymentMethod = 'credit_card';
$payment = PaymentFactory::createPayment($paymentMethod);
$payment->process();