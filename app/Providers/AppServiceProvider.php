<?php

namespace App\Providers;

use App\Repositories\Dishes\DishRepository;
use App\Repositories\Dishes\DishRepositoryInterface;
use App\Repositories\MealCategories\MealCategoryRepository;
use App\Repositories\MealCategories\MealCategoryRepositoryInterface;
use App\Repositories\Restaurants\RestaurantRepository;
use App\Repositories\Restaurants\RestaurantRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DishRepositoryInterface::class, DishRepository::class);
        $this->app->bind(MealCategoryRepositoryInterface::class, MealCategoryRepository::class);
        $this->app->bind(RestaurantRepositoryInterface::class, RestaurantRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
