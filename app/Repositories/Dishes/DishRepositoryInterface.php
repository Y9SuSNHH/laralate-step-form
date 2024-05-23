<?php

declare(strict_types=1);

namespace App\Repositories\Dishes;

use App\Entities\Dish;

interface DishRepositoryInterface
{
    public function getAll(): array;

    public function getByMealAndRestaurant(string $meal, string $restaurant): array;
}
