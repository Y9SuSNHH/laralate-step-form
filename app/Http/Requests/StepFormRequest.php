<?php

namespace App\Http\Requests;

use App\Entities\StepEnum;
use App\Repositories\Dishes\DishRepositoryInterface;
use App\Repositories\MealCategories\MealCategoryRepositoryInterface;
use App\Repositories\Restaurants\RestaurantRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class StepFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var DishRepositoryInterface $dishRepository */
        $dishRepository = app()->make(DishRepositoryInterface::class);
        /** @var MealCategoryRepositoryInterface $mealCategoryRepository */
        $mealCategoryRepository = app()->make(MealCategoryRepositoryInterface::class);
        /** @var RestaurantRepositoryInterface $restaurantRepository */
        $restaurantRepository = app()->make(RestaurantRepositoryInterface::class);

        return [
            "meal"             => [
                Rule::in(Arr::pluck($mealCategoryRepository->getAll(), 'name')),
                Rule::requiredIf(fn() => (int) $this->step === StepEnum::SECOND->value),
            ],
            "number_of_people" => [
                'numeric',
                Rule::requiredIf(fn() => (int) $this->step === StepEnum::SECOND->value),
            ],
            "restaurant"       => [
                Rule::in(Arr::pluck($restaurantRepository->getAll(), 'name')),
                Rule::requiredIf(fn() => (int) $this->step === StepEnum::THIRD->value),
            ],
            "dish.*"           => [
                Rule::in(Arr::pluck($dishRepository->getByMealAndRestaurant($this->meal ?? '', $this->restaurant ?? ''),
                    'id')),
                Rule::requiredIf(fn() => (int) $this->step === StepEnum::FOURTH->value),
            ],
            "quantity.*"       => [
                'integer',
                Rule::requiredIf(fn() => (int) $this->step === StepEnum::FOURTH->value),
            ],
            "step"             => [
                'nullable',
                Rule::in(array_column(StepEnum::cases(), 'value')),
            ],
        ];
    }
}
