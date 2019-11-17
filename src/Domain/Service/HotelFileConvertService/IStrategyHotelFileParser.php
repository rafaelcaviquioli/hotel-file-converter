<?php

namespace App\Domain\Service\HotelFileConvertService;

use App\Domain\BusinessConstraint\HotelBusinessConstraintValidator;

interface IStrategyHotelFileParser
{
    public function __construct(
        string $fileContent,
        HotelBusinessConstraintValidator $hotelBusinessConstraintValidator
    );
    public function getHotels(): array;
}
