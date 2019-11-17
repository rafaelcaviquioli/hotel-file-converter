<?php

namespace App\Domain\Service\HotelFileConvertService;

use App\Domain\Model\HotelModel;

class StrategyJsonHotelFileParser implements IStrategyHotelFileParser
{
    private $hotelsJsonDecoded;

    public function __construct(string $fileContent)
    {
        $this->hotelsJsonDecoded = json_decode($fileContent, true);
    }

    public function getHotels(): array
    {
        if (count($this->hotelsJsonDecoded) == 0) {
            return [];
        }

        $hotels = [];
        foreach ($this->hotelsJsonDecoded as $hotel) {
            $hotels[] = new HotelModel(
                $hotel['name'],
                $hotel['address'],
                $hotel['stars'],
                $hotel['contact'],
                $hotel['phone'],
                $hotel['uri']
            );
        }

        return $hotels;
    }
}
