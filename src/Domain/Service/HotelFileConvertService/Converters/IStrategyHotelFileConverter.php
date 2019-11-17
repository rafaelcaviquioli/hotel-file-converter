<?php

namespace App\Domain\Service\HotelFileConvertService\Converters;

interface IStrategyHotelFileConverter
{
    /** @param App\Domain\Model\HotelModel[] $hotels */
    public function convert(array $hotels): string;
}
