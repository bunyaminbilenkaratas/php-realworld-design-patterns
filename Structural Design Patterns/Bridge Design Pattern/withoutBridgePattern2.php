<?php

class ABankUSD {
    private $balance;

    public function __construct($balance) {
        $this->balance = $balance;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function withdraw($amount) {
        if ($amount > $this->balance) {
            echo "Insufficient funds in ABankUSD account.";
        } else {
            $this->balance -= $amount;
            echo "Withdrew " . $amount . " from ABankUSD account. New balance: " . $this->balance;
        }
    }
}

class BBankUSD {
    private $balance;

    public function __construct($balance) {
        $this->balance = $balance;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function withdraw($amount) {
        if ($amount > $this->balance) {
            echo "Insufficient funds in BBankUSD account.";
        } else {
            $this->balance -= $amount;
            echo "Withdrew " . $amount . " from BBankUSD account. New balance: " . $this->balance;
        }
    }
}

class ABankEUR {
    private $balance;

    public function __construct($balance) {
        $this->balance = $balance;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function withdraw($amount) {
        if ($amount > $this->balance) {
            echo "Insufficient funds in ABankEuro account.";
        } else {
            $this->balance -= $amount;
            echo "Withdrew " . $amount . " from ABankEuro account. New balance: " . $this->balance;
        }
    }
}

class BBankEUR {
    private $balance;

    public function __construct($balance) {
        $this->balance = $balance;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function withdraw($amount) {
        if ($amount > $this->balance) {
            echo "Insufficient funds in BBankEuro account.";
        } else {
            $this->balance -= $amount;
            echo "Withdrew " . $amount . " from BBankEuro account. New balance: " . $this->balance;
        }
    }
}

// Example usage
$abankUSD = new ABankUSD(1000);
echo $abankUSD->getBalance() . "\n";

$bbankUSD = new BBankUSD(2000);
echo $bbankUSD->getBalance() . "\n";

$abankEUR = new ABankEUR(1500);
echo $abankEUR->getBalance() . "\n";

$bbankEUR = new BBankEUR(2500);
echo $bbankEUR->getBalance() . "\n";
