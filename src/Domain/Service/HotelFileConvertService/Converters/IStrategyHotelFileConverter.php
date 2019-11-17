<?php

namespace App\Domain\Service\HotelFileConvertService\Converters;

use Iterator;

interface IStrategyHotelFileConverter
{
    /** @param App\Domain\Model\HotelModel[] $hotels */
    public function convert(array $hotels): Iterator;
}
