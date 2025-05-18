<?php

class Land
{
    protected int $size;
    protected string $color;
    protected string $ground;
    protected string $season;
    protected string $weather;

    public function __construct(LandBuilder $builder)
    {
        $this->size = $builder->size;
        $this->color = $builder->color;
        $this->ground = $builder->ground;
        $this->season = $builder->season;
        $this->weather = $builder->weather;
    }

    public function printLand(): void {
        echo 'Built Land: ' . PHP_EOL;
        echo 'Size: ' . $this->size . PHP_EOL;
        echo 'Color: ' . $this->color . PHP_EOL;
        echo 'Ground: ' . $this->ground . PHP_EOL;
        echo 'Season: ' . $this->season . PHP_EOL;
        echo 'Weather: ' . $this->weather . PHP_EOL;
    }
}

class LandBuilder
{
    public int $size;
    public string $color;
    public string $ground;
    public string $season;
    public string $weather;

    public function size(int $size): LandBuilder {
        $this->size = $size;
        return $this;
    }

    public function color(string $color): LandBuilder {
        $this->color = $color;
        return $this;
    }

    public function ground(string $ground): LandBuilder {
        $this->ground = $ground;
        return $this;
    }

    public function season(string $season): LandBuilder {
        $this->season = $season;
        return $this;
    }

    public function weather(string $weather): LandBuilder {
        $this->weather = $weather;
        return $this;
    }

    public function build(): Land
    {
        return new Land($this);
    }
}

$land = (new LandBuilder())
    ->size(12)
    ->color('red')
    ->ground('Grass')
    ->season('Summer')
    ->weather("cloudy")
    ->build();

$land->printLand();
