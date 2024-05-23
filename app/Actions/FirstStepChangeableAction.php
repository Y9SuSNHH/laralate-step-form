<?php

declare(strict_types=1);

namespace App\Actions;

use App\Entities\StepEnum;

final class FirstStepChangeableAction extends AbstractStepChangeable
{
    protected function getChangeableSteps($step): array
    {
        return [
            StepEnum::FIRST,
            StepEnum::SECOND,
        ];
    }
}
