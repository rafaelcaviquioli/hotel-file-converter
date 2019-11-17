<?php

namespace App\Domain\Service\HotelFileConvertService;

interface IStrategyHotelFileParser
{
    public function __construct(string $fileContent);
    public function getHotels() : array;
}
