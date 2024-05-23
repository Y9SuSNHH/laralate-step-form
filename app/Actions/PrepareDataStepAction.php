<?php

declare(strict_types=1);

namespace App\Actions;

use App\Entities\MealCategory;
use App\Entities\StepEnum;
use App\Repositories\Dishes\DishRepositoryInterface;
use App\Repositories\MealCategories\MealCategoryRepositoryInterface;
use App\Repositories\Restaurants\RestaurantRepositoryInterface;

final class PrepareDataStepAction
{
    public function __construct(
        protected DishRepositoryInterface $dishesRepository,
        protected MealCategoryRepositoryInterface $mealCategory,
        protected RestaurantRepositoryInterface $restaurantRepository,
    ) {}

    public function __invoke(StepEnum $stepEnum, array $attribute = []): array
    {
        return match ($stepEnum) {
            StepEnum::SECOND => $this->prepareSecondStepData(),
            StepEnum::THIRD => $this->prepareThirdStepData($attribute),
            StepEnum::FOURTH => $this->prepareFourthStepData($attribute),
            default => $this->prepareFirstStepData(),
        };
    }

    protected function prepareFirstStepData(): array
    {
        $mealCategories = $this->mealCategory->getAll();
        return compact('mealCategories');
    }

    protected function prepareSecondStepData(): array
    {
        $restaurants = $this->restaurantRepository->getAll();
        return compact('restaurants');
    }

    protected function prepareThirdStepData(array $attribute): array
    {
        $dishes = $this->dishesRepository->getByMealAndRestaurant($attribute['meal'], $attribute['restaurant']);
        return compact('dishes');
    }

    protected function prepareFourthStepData(array $attribute): array
    {
        $mealCategories = $this->mealCategory->getAll();
        $restaurants    = $this->restaurantRepository->getAll();
        $dishes         = $this->dishesRepository->getAll();
        return compact('dishes', 'mealCategories', 'restaurants');
    }
}
