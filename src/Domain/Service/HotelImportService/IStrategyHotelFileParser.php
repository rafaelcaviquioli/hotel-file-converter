<?php

namespace App\Domain\Service\HotelImportService;

interface IStrategyHotelFileParser
{
    public function __construct($filePath);
    public function getHotels() : array;
}
