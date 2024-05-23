<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel - Multi-Step Form</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="container mx-auto px-4 py-8">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form id="multi-step-form" action="{{ route('step-form', $step + 1) }}" method="GET">
                @csrf
                @if($step !== \App\Entities\StepEnum::FOURTH->value)
                    @foreach(request()->except(['_token', 'step']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                @endif
                <div id="steps" class="flex flex-col">
                    @include('partials.step-content', ['step' => $step])
                    <input type="hidden" id="step" name="step" value="{{ $step }}">
                    <div class="flex justify-between pt-4">
                        @if($first_step !== $step)
                            <button type="button" id="previous-button"
                                    class="btn px-4 py-2 rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                            >Previous
                            </button>
                        @endif
                        <button type="submit"
                                class="btn px-4 py-2 rounded-md text-white bg-indigo-500 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                        >
                            @if($last_step === $step)
                                Submit
                            @else
                                Next
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('previous-button').addEventListener('click', function() {
        window.history.back();
    });

</script>

<script src="{{ asset('js/form.js') }}"></script>

</body>
</html>
