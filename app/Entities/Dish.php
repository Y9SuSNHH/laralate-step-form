<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Support\Arr;

final class Dish
{
    public Restaurant $restaurant;
    public array $availableMeals;

    public function __construct(
        public int $id,
        public string $name,
    ) {}

    public function setRestaurant(string $restaurant): void
    {
        $this->restaurant = new Restaurant($restaurant);
    }

    public function setAvailableMeals(array $availableMeals): void
    {
        $this->availableMeals = Arr::map($availableMeals,
            fn(string $meal): MealCategory => new MealCategory($meal));
    }
}
