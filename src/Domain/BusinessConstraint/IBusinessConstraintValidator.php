<?php

namespace App\Domain\BusinessConstraint;

interface IBusinessConstraintValidator
{
    public function validate(int $index, $model): array;
}
