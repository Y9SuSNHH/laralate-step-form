<?php

declare(strict_types=1);

namespace App\Repositories\MealCategories;

use App\Entities\MealCategory;

interface MealCategoryRepositoryInterface
{

    /**
     * @return MealCategory[]
     */
    public function getAll(): array;
}
