<?php

interface AccountVisitor
{
    public function visitSavingAccount(SavingAccount $account);

    public function visitCreditAccount(CreditAccount $account);

    public function visitInvestmentAccount(InvestmentAccount $account);
}

interface Account
{
    public function accept(AccountVisitor $visitor);
}

class SavingAccount implements Account
{
    public $balance;

    public function __construct($balance)
    {
        $this->balance = $balance;
    }

    public function accept(AccountVisitor $visitor)
    {
        $visitor->visitSavingAccount($this);
    }
}

class CreditAccount implements Account
{
    public $balance;
    public $creditLimit;

    public function __construct($balance, $creditLimit)
    {
        $this->balance = $balance;
        $this->creditLimit = $creditLimit;
    }

    public function accept(AccountVisitor $visitor)
    {
        $visitor->visitCreditAccount($this);
    }
}

class InvestmentAccount implements Account
{
    public $balance;
    public $investmentRate;

    public function __construct($balance, $investmentRate)
    {
        $this->balance = $balance;
        $this->investmentRate = $investmentRate;
    }

    public function accept(AccountVisitor $visitor)
    {
        $visitor->visitInvestmentAccount($this);
    }
}

// Concrete Visitor: Profit Share Calculator
class ProfitShareCalculator implements AccountVisitor
{
    public function visitSavingAccount(SavingAccount $account)
    {
        $profitShare = $account->balance * 0.02; // 2% profit share for saving accounts
        echo "SavingAccount Profit Share: $profitShare\n";
    }

    public function visitCreditAccount(CreditAccount $account)
    {
        // For credit accounts, profit share only if balance is positive
        if ($account->balance > 0) {
            $profitShare = $account->balance * 0.01; // 1% profit share on positive balance
            echo "CreditAccount Profit Share: $profitShare\n";
        } else {
            echo "CreditAccount has no positive balance, no profit share.\n";
        }
    }

    public function visitInvestmentAccount(InvestmentAccount $account)
    {
        $profitShare = $account->balance * $account->investmentRate; // Profit depends on investment rate
        echo "InvestmentAccount Profit Share: $profitShare\n";
    }
}

// Concrete Visitor: Account Summary Printer
class AccountSummaryPrinter implements AccountVisitor
{
    public function visitSavingAccount(SavingAccount $account)
    {
        echo "SavingAccount with balance: {$account->balance}\n";
    }

    public function visitCreditAccount(CreditAccount $account)
    {
        echo "CreditAccount with balance: {$account->balance} and credit limit: {$account->creditLimit}\n";
    }

    public function visitInvestmentAccount(InvestmentAccount $account)
    {
        echo "InvestmentAccount with balance: {$account->balance} and investment rate: {$account->investmentRate}\n";
    }
}

// Client code
$accounts = [
    new SavingAccount(1000),
    new CreditAccount(500, 1000),
    new InvestmentAccount(2000, 0.07),
];

$profitShareCalculator = new ProfitShareCalculator();
$summaryPrinter = new AccountSummaryPrinter();

echo "=== Profit Share Calculation ===\n";
foreach ($accounts as $account) {
    $account->accept($profitShareCalculator);
}

echo "\n=== Account Summary ===\n";
foreach ($accounts as $account) {
    $account->accept($summaryPrinter);
}
