<?php

namespace App\Domain\Service\HotelFileConvertService\Parsers;

use App\Domain\BusinessConstraint\HotelBusinessConstraintValidator;
use App\Domain\Model\HotelModel;

class StrategyXmlHotelFileParser implements IStrategyHotelFileParser
{
    private $hotelsXml;
    private $hotelBusinessConstraintValidator;

    public function __construct(
        string $fileContent,
        HotelBusinessConstraintValidator $hotelBusinessConstraintValidator
    ) {
        $this->hotelsXml = simplexml_load_string($fileContent);
        $this->hotelBusinessConstraintValidator = $hotelBusinessConstraintValidator;
    }

    public function getHotels(): array
    {
        if (count($this->hotelsXml->hotel) == 0) {
            return [];
        }

        $hotels = [];
        foreach ($this->hotelsXml->hotel as $hotelObject) {
            $hotelModel = new HotelModel(
                $hotelObject->name,
                $hotelObject->address,
                (int) $hotelObject->stars,
                $hotelObject->contact,
                $hotelObject->phone,
                $hotelObject->uri
            );

            $this->hotelBusinessConstraintValidator->validate($hotelModel);

            if (!$this->hotelBusinessConstraintValidator->hasErrors()) {
                $hotels[] = $hotelModel;
            }
        }

        return $hotels;
    }
}
