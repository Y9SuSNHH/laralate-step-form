<?php

declare(strict_types=1);

namespace App\Actions;

use App\Entities\StepEnum;

final class StepChangeableAction
{
    public function __construct(
        protected FirstStepChangeableAction $firstStepChangeable,
        protected SecondStepChangeableAction $secondStepChangeable,
        protected ThirdStepChangeableAction $thirdStepChangeable,
        protected FourthStepChangeableAction $fourthStepChangeable,
    ) {}

    public function canChangeStatus(StepEnum $step, StepEnum $new_step): bool
    {
        return match ($step) {
            StepEnum::FIRST => ($this->firstStepChangeable)($step, $new_step),
            StepEnum::SECOND => ($this->secondStepChangeable)($step, $new_step),
            StepEnum::THIRD => ($this->thirdStepChangeable)($step, $new_step),
            StepEnum::FOURTH => ($this->fourthStepChangeable)($step, $new_step),
            default => false,
        };
    }

    public function __invoke(StepEnum $step, StepEnum $new_step): bool
    {
        return $this->canChangeStatus($step, $new_step);
    }
}
