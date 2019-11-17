<?php

namespace App\Domain\Service\HotelFileConvertService\Converters;

use Iterator;
use League\Csv\Writer;

class StrategyCsvHotelFileConverter implements IStrategyHotelFileConverter
{
    /** @param App\Domain\Model\HotelModel[] $hotels */
    public function convert(array $hotels): Iterator
    {
        foreach ($hotels as $hotel) {
            $hotelFields = [
                $hotel->getName(),
                $hotel->getAddress(),
                $hotel->getStars(),
                $hotel->getContact(),
                $hotel->getPhone(),
                $hotel->getUri()
            ];

            yield self::arrayToCsv($hotelFields);
        }
    }

    private static function arrayToCsv(array $fields): string
    {
        $writer = Writer::createFromString();
        $writer->insertOne($fields);
        $csvContent = $writer->getContent();

        return $csvContent;
    }
}
