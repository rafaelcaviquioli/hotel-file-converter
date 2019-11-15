<?php

namespace App\Domain\Service\HotelImportService;

class StrategyJsonFileParser implements IStrategyHotelFileParser
{
    public function __construct($filePath)
    { }

    public function getHotels(): array
    {
        return [];
    }
}
