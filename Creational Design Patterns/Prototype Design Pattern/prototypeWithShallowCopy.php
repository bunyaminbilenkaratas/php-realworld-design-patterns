<?php

class InvoiceDocument {
    private $title;
    private $content;

    public function __construct(string $title, string $content) {
        $this->title = $title;
        $this->content = $content;
        $heavyProcess = sleep(3);
    }

    public function customize(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    public function render()
    {
        echo "Invoice Title: {$this->title}\nContent: {$this->content}\n\n";
    }
}

$invoice = new InvoiceDocument("Default Invoice", "This is a default invoice template.");

$invoice1 = clone $invoice;
$invoice1->customize("Invoice #123", "Payment for service.");

$invoice2 = clone $invoice;
$invoice2->customize("Invoice #124", "Payment for monthly subscription.");

$invoice1->render();
$invoice2->render();
