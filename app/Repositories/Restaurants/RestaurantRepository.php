<?php

declare(strict_types=1);

namespace App\Repositories\Restaurants;

use App\Entities\Restaurant;
use Illuminate\Support\Arr;

final class RestaurantRepository implements RestaurantRepositoryInterface
{
    /**
     * @return Restaurant[]
     */
    public function getAll(): array
    {
        return $this->transforms($this->all());
    }

    protected function all(): array
    {
        return [
            "Mc Donalds",
            "Taco Bell",
            "BBQ Hut",
            "Vege Deli",
            "Pizzeria",
            "Panda Express",
            "Olive Garden",
        ];
    }

    protected function dto(string $name): Restaurant
    {
        return new Restaurant($name);
    }

    protected function transforms(array $attributes): array
    {
        return Arr::map($attributes, fn(string $name): Restaurant => $this->dto($name));
    }
}
