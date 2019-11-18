<?php

namespace App\Domain\Service\HotelFileConvertService\Parsers;

use App\Domain\BusinessConstraint\HotelBusinessConstraintValidator;
use App\Domain\Model\HotelModel;

class StrategyJsonHotelFileParser implements IStrategyHotelFileParser
{
    private $hotelsJsonDecoded;
    private $hotelBusinessConstraintValidator;

    public function __construct(
        string $fileContent,
        HotelBusinessConstraintValidator $hotelBusinessConstraintValidator
    ) {
        $this->hotelsJsonDecoded = json_decode($fileContent, true);
        $this->hotelBusinessConstraintValidator = $hotelBusinessConstraintValidator;
    }

    public function getHotels(): array
    {
        if (count($this->hotelsJsonDecoded) == 0) {
            return [];
        }

        $hotels = [];
        for ($index = 0; $index < count($this->hotelsJsonDecoded); $index++) {
            $hotelObject = $this->hotelsJsonDecoded[$index];

            $hotelModel = new HotelModel(
                $hotelObject['name'],
                $hotelObject['address'],
                (int) $hotelObject['stars'],
                $hotelObject['contact'],
                $hotelObject['phone'],
                $hotelObject['uri']
            );

            $this->hotelBusinessConstraintValidator->validate($index, $hotelModel);

            if (!$this->hotelBusinessConstraintValidator->hasErrors()) {
                $hotels[] = $hotelModel;
            }
        }

        return $hotels;
    }
}
