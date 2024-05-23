<?php

declare(strict_types=1);

namespace App\Actions;

use App\Entities\StepEnum;

abstract class AbstractStepChangeable
{
    public function __construct() {}

    public function __invoke(StepEnum $step, StepEnum $new_step): bool
    {
        return $this->canChangeStatus($step, $new_step);
    }

    private function canChangeStatus(StepEnum $stepEnum, StepEnum $newStepEnum): bool
    {
        if (empty($steps = $this->getChangeableSteps($stepEnum))) {
            return false;
        }
        $canChanges = array_filter($steps, fn(StepEnum $step) => $step === $newStepEnum);

        return !empty($canChanges);
    }

    abstract protected function getChangeableSteps($step): array;
}
