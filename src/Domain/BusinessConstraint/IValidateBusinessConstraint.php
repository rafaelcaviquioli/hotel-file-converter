<?php

namespace App\Domain\BusinessConstraint;

interface IValidateBusinessConstraint
{
    public function getValidateErrors($model): array;
}
