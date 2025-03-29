<?php

interface Payment {
    public function process();
}

class CreditCardPayment implements Payment {
    public function process() {
        echo "Processing credit card payment";
    }
}

class PaypalPayment implements Payment {
    public function process() {
        echo "Processing paypal payment";
    }
}

class PaymentStaticFactory {
    public static function create($type): Payment {
        if ($type === 'credit_card') {
            return new CreditCardPayment();
        } elseif ($type === 'paypal') {
            return new PaypalPayment();
        } else {
            throw new Exception("Payment method not supported");
        }
    }
}

//Usage
$paymentMethod = 'credit_card';
$payment = PaymentStaticFactory::create($paymentMethod);
$payment->process();
