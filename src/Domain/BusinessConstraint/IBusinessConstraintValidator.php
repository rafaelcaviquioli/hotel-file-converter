<?php

namespace App\Domain\BusinessConstraint;

interface IBusinessConstraintValidator
{
    public function validate($model): array;
}
