<?php
// It is especially used when the algorithm needs to be changed at runtime.

interface RouteStrategy
{
    public function buildRoute(string $start, string $end): void;
}

class WalkingStrategy implements RouteStrategy
{
    public function buildRoute(string $start, string $end): void
    {
        echo "Walking route from $start to $end.\n";
    }
}

class BikingStrategy implements RouteStrategy
{
    public function buildRoute(string $start, string $end): void
    {
        echo "Biking route from $start to $end.\n";
    }
}

class DrivingStrategy implements RouteStrategy
{
    public function buildRoute(string $start, string $end): void
    {
        echo "Driving route from $start to $end.\n";
    }
}

class Navigator // Context
{
    private RouteStrategy $strategy;

    public function __construct(RouteStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function setStrategy(RouteStrategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function buildRoute(string $start, string $end): void
    {
        $this->strategy->buildRoute($start, $end);
    }
}

// Example usage
$navigator = new Navigator(new WalkingStrategy());
$navigator->buildRoute("Home", "Park");

$navigator->setStrategy(new BikingStrategy());
$navigator->buildRoute("Home", "Store");

$navigator->setStrategy(new DrivingStrategy());
$navigator->buildRoute("Home", "Office");
