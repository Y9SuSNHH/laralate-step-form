<?php

namespace App\Http\Controllers;

use App\Actions\PrepareDataStepAction;
use App\Actions\StepChangeableAction;
use App\Entities\StepEnum;
use App\Http\Requests\StepFormRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class StepFormController extends Controller
{
    public function index(
        StepFormRequest $request,
        StepChangeableAction $stepChangeableAction,
        PrepareDataStepAction $prepareDataStepAction,
        ?int $step = 1,
    ): View {
        $previousStepEnum = StepEnum::tryFrom($request->get('step', 1));
        $stepEnum         = StepEnum::tryFrom($step);

        $data = $prepareDataStepAction($stepEnum, $request->validated());

        if ($stepChangeableAction($previousStepEnum, $stepEnum)) {
            $step = $stepEnum->value;
            if ($step === StepEnum::FIFTH->value) {
                return view('welcome');
            }
        }

        $first_step = StepEnum::FIRST->value;
        $last_step  = StepEnum::FOURTH->value;

        return view('step-form', compact('data', 'step', 'last_step', 'first_step'));
    }
}
