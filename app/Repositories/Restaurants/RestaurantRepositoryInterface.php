<?php

declare(strict_types=1);

namespace App\Repositories\Restaurants;

use App\Entities\Restaurant;

interface RestaurantRepositoryInterface
{

    /**
     * @return Restaurant[]
     */
    public function getAll(): array;
}
