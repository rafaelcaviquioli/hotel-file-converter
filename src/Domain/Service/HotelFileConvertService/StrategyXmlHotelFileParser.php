<?php

namespace App\Domain\Service\HotelFileConvertService;

class StrategyXmlHotelFileParser implements IStrategyHotelFileParser
{
    public function __construct($fileContent)
    { }

    public function getHotels(): array
    {
        return [];
    }
}
