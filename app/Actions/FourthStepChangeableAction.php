<?php

declare(strict_types=1);

namespace App\Actions;

use App\Entities\StepEnum;

final class FourthStepChangeableAction extends AbstractStepChangeable
{
    protected function getChangeableSteps($step): array
    {
        return [
            StepEnum::THIRD,
            StepEnum::FIFTH,
        ];
    }
}
