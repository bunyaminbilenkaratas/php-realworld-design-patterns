<?php

interface Expression
{
    public function interpret(): int;
}

class NumberExpression implements Expression
{
    private int $number;

    public function __construct(int $number)
    {
        $this->number = $number;
    }

    public function interpret(): int
    {
        return $this->number;
    }
}

class AddExpression implements Expression
{
    private Expression $left;
    private Expression $right;

    public function __construct(Expression $left, Expression $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    public function interpret(): int
    {
        return $this->left->interpret() + $this->right->interpret();
    }
}

class SubtractExpression implements Expression
{
    private Expression $left;
    private Expression $right;

    public function __construct(Expression $left, Expression $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    public function interpret(): int
    {
        return $this->left->interpret() - $this->right->interpret();
    }
}

// Usage

$expression = new SubtractExpression(
    new AddExpression(
        new NumberExpression(5),
        new NumberExpression(10)
    ),
    new NumberExpression(3)
);

echo $expression->interpret(); // 12
