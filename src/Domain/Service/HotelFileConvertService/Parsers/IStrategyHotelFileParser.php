<?php

namespace App\Domain\Service\HotelFileConvertService\Parsers;

use App\Domain\BusinessConstraint\HotelBusinessConstraintValidator;

interface IStrategyHotelFileParser
{
    public function __construct(
        string $fileContent,
        HotelBusinessConstraintValidator $hotelBusinessConstraintValidator
    );

    /** @return App\Domain\Model\HotelModel[] */
    public function getHotels(): array;
}
