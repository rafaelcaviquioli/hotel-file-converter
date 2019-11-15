<?php

namespace App\Domain\Service\HotelImportService;

class StrategyXmlFileParser implements IStrategyHotelFileParser
{
    public function __construct($filePath)
    { }

    public function getHotels(): array
    {
        return [];
    }
}
