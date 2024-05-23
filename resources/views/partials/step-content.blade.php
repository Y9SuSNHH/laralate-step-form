@switch($step)
    @case(1)
        <label for="meal" class="block text-sm font-medium leading-6 text-gray-900">Meal</label>
        <div class="mt-2">
            <select id="meal" name="meal"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                @foreach($data['mealCategories'] as $mealCategory)
                    <option
                        value="{{$mealCategory->name}}" {{ $mealCategory->name === request()->get('meal') ? "selected" : "" }}>{{$mealCategory->name}}</option>
                @endforeach
            </select>
        </div>
        <label for="number_of_people" class="block text-sm font-medium leading-6 text-gray-900">Number of people</label>
        <div class="mt-2">
            <input type="number" name="number_of_people" id="number_of_people"
                   value="{{request()->get('number_of_people', 1 )}}"
                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
        @break
    @case(2)
        <label for="restaurant">Restaurant</label>
        <div class="mt-2">
            <select id="restaurant" name="restaurant"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                @foreach($data['restaurants'] as $restaurant)
                    <option
                        value="{{$restaurant->name}}" {{ $restaurant->name === request()->get('restaurant') ? "selected" : "" }}>{{$restaurant->name}}</option>
                @endforeach
            </select>
        </div>
        @break
    @case(3)
        <div id="dish-container">
            <div class="sm:col-span-1">
                <label for="add" class="block text-sm font-medium leading-6 text-gray-900">Add</label>
                <div class="mt-2">
                    <button type="button" id="add-dish"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        +
                    </button>
                </div>
            </div>
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                @foreach(request()->get('dish', []) as $index => $dishId)
                    <div class="sm:col-span-3">
                        <label for="dish">Dish</label>
                        <div class="mt-2">
                            <select name="dish[]"
                                    class="dish-select block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                @foreach($data['dishes'] as $dish)
                                    <option value="{{$dish->id}}" {{ $dish->id == $dishId ? 'selected' : '' }}>{{$dish->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="sm:col-span-3">
                        <label for="quantity" class="block text-sm font-medium leading-6 text-gray-900">Số lượng</label>
                        <div class="mt-2">
                            <input type="number" name="quantity[]" class="quantity-input block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ request()->get('quantity', [$index => 1])[$index] }}">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const maxDishes = 10;
                const numberOfPeople = {{ request()->get('number_of_people') }};
                const dishContainer = document.getElementById('dish-container');

                function validateDishes() {
                    let totalQuantity = 0;
                    document.querySelectorAll('.quantity-input').forEach(input => {
                        totalQuantity += parseInt(input.value);
                    });

                    return totalQuantity === 0 || (totalQuantity >= numberOfPeople && totalQuantity <= maxDishes);
                }

                function dishExists(dishSelect) {
                    let selectedDishes = [];
                    document.querySelectorAll('.dish-select').forEach(select => {
                        if (select !== dishSelect && select.value !== '') {
                            selectedDishes.push(select.value);
                        }
                    });
                    return selectedDishes.includes(dishSelect.value);
                }

                document.getElementById('add-dish').addEventListener('click', function () {
                    if (!validateDishes()) {
                        alert(`Total number of servings must be between ${numberOfPeople} and ${maxDishes}.`);
                        return;
                    }

                    const newDishRow = document.createElement('div');
                    newDishRow.classList.add('mt-10', 'grid', 'grid-cols-1', 'gap-x-6', 'gap-y-8', 'sm:grid-cols-6');

                    newDishRow.innerHTML = `
            <div class="sm:col-span-3">
                <label for="dish">Dish</label>
                <div class="mt-2">
                    <select name="dish[]" class="dish-select block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        @foreach($data['dishes'] as $dish)
                    <option value="{{$dish->id}}">{{$dish->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="sm:col-span-3">
                <label for="quantity" class="block text-sm font-medium leading-6 text-gray-900">Số lượng</label>
                <div class="mt-2">
                    <input type="number" name="quantity[]" class="quantity-input block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="1">
                </div>
            </div>
        `;

                    dishContainer.appendChild(newDishRow);

                    const newDishSelect = newDishRow.querySelector('.dish-select');
                    newDishSelect.addEventListener('change', function (e) {
                        if (dishExists(newDishSelect)) {
                            alert('You have already selected this dish.');
                            newDishSelect.value = '';
                        }
                    });

                    newDishRow.querySelector('.quantity-input').addEventListener('input', function () {
                        if (!validateDishes()) {
                            alert(`Total number of servings must be between ${numberOfPeople} and ${maxDishes}.`);
                        }
                    });
                });

                document.querySelectorAll('.dish-select').forEach(select => {
                    select.addEventListener('change', function (e) {
                        if (dishExists(select)) {
                            alert('You have already selected this dish.');
                            e.target.value = '';
                        }
                    });
                });

                document.querySelectorAll('.quantity-input').forEach(input => {
                    input.addEventListener('input', function () {
                        if (!validateDishes()) {
                            alert(`Total number of servings must be between ${numberOfPeople} and ${maxDishes}.`);
                        }
                    });
                });
            });
        </script>
        @break
    @case(4)
        <h2 class="text-xl font-semibold leading-7 text-gray-900">Review Your Order</h2>
        <div class="mt-4">
            <p><strong>Meal:</strong> {{ request()->get('meal') }}</p>
            <p><strong>Number of People:</strong> {{ request()->get('number_of_people') }}</p>
            <p><strong>Restaurant:</strong> {{ request()->get('restaurant') }}</p>
        </div>
        <div class="mt-4">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Dishes</h3>
            <ul class="list-disc pl-5">
                @foreach(request()->get('dish') as $index => $dishId)
                    <li>{{ \Illuminate\Support\Arr::first($data['dishes'], fn($dish) => $dish->id === (int) $dishId)->name }} - Quantity: {{ request()->get('quantity')[$index] }}</li>
                @endforeach
            </ul>
        </div>
        @break
    @default
@endswitch
