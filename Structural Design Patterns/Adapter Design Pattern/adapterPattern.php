<?php

interface PaymentGatewayInterface {
    public function pay(int $referenceNumber, float $amount): bool;
}

class WebmoneyService {
    public function proccessPayment(array $data): string {
        return ($data['amount'] > 0) ? "success" : "failure";
    }
}

class WebmoneyPaymentAdapter implements PaymentGatewayInterface {
    protected $webmoneyService;

    public function __construct(WebmoneyService $webmoneyService) {
        $this->webmoneyService = $webmoneyService;
    }

    public function pay(int $referenceNumber, float $amount): bool {
        $data['amount'] = $amount;
        return $this->webmoneyService->proccessPayment($data) === 'success';
    }
}

//Usage:
$paymentGateway = new WebmoneyPaymentAdapter(new WebmoneyService());
echo $paymentGateway->pay(15, 155,5) . PHP_EOL;
