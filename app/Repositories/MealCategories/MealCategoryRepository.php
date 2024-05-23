<?php

declare(strict_types=1);

namespace App\Repositories\MealCategories;

use App\Entities\MealCategory;
use Illuminate\Support\Arr;

final class MealCategoryRepository implements MealCategoryRepositoryInterface
{
    /**
     * @return MealCategory[]
     */
    public function getAll(): array
    {
        return $this->transforms($this->all());
    }

    protected function all(): array
    {
        return [
            "breakfast",
            "lunch",
            "dinner",
        ];
    }

    protected function dto(string $name): MealCategory
    {
        return new MealCategory($name);
    }

    protected function transforms(array $attributes): array
    {
        return Arr::map($attributes, fn(string $name): MealCategory => $this->dto($name));
    }
}
