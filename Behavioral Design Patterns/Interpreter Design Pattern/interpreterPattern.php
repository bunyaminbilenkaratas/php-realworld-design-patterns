<?php

interface Expression
{
    public function interpret(User $user): bool;
}

class User
{
    public int $age;
    public string $country;
    public string $subscription;

    public function __construct(int $age, string $country, string $subscription)
    {
        $this->age = $age;
        $this->country = $country;
        $this->subscription = $subscription;
    }
}

class AgeExpression implements Expression
{
    private int $minAge;

    public function __construct(int $minAge)
    {
        $this->minAge = $minAge;
    }

    public function interpret(User $user): bool
    {
        return $user->age >= $this->minAge;
    }
}

class CountryExpression implements Expression
{
    private string $country;

    public function __construct(string $country)
    {
        $this->country = $country;
    }

    public function interpret(User $user): bool
    {
        return strtolower($user->country) === strtolower($this->country);
    }
}

class SubscriptionExpression implements Expression
{
    private string $subscription;

    public function __construct(string $subscription)
    {
        $this->subscription = $subscription;
    }

    public function interpret(User $user): bool
    {
        return strtolower($user->subscription) === strtolower($this->subscription);
    }
}

class AndExpression implements Expression
{
    private Expression $expr1;
    private Expression $expr2;

    public function __construct(Expression $expr1, Expression $expr2)
    {
        $this->expr1 = $expr1;
        $this->expr2 = $expr2;
    }

    public function interpret(User $user): bool
    {
        return $this->expr1->interpret($user) && $this->expr2->interpret($user);
    }
}

class OrExpression implements Expression
{
    private Expression $expr1;
    private Expression $expr2;

    public function __construct(Expression $expr1, Expression $expr2)
    {
        $this->expr1 = $expr1;
        $this->expr2 = $expr2;
    }

    public function interpret(User $user): bool
    {
        return $this->expr1->interpret($user) || $this->expr2->interpret($user);
    }
}

// Usage:

$user1 = new User(20, 'Turkey', 'premium');
$user2 = new User(16, 'Germany', 'free');

// Rule: User must be at least 18 years old and from Turkey
$rule1 = new AndExpression(
    new AgeExpression(18),
    new CountryExpression('Turkey')
);

// Rule: User must have a premium subscription
$finalRule = new OrExpression(
    $rule1,
    new SubscriptionExpression('premium')
);

echo 'Is User1 eligible? ' . ($finalRule->interpret($user1) ? 'Yes' : 'No') . "\n"; // Yes
echo 'Is User2 eligible? ' . ($finalRule->interpret($user2) ? 'Yes' : 'No') . "\n"; // No
