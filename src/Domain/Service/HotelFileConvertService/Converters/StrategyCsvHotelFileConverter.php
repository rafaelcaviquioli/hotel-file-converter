<?php

namespace App\Domain\Service\HotelFileConvertService\Converters;

class StrategyCsvHotelFileConverter implements IStrategyHotelFileConverter
{
    /** @param App\Domain\Model\HotelModel[] $hotels */
    public function convert(array $hotels): string
    {
        $csvContent = "";
        
        foreach ($hotels as $hotel) {
            $hotelFields = [
                'name' => $hotel->getName(),
                'address' => $hotel->getAddress(),
                'stars' => $hotel->getStars(),
                'contact' => $hotel->getContact(),
                'phone' => $hotel->getPhone(),
                'uri' => $hotel->getUri()
            ];
            
            $csvContent .= $this->arrayToCsvString($hotelFields) . PHP_EOL;
        }

        return $csvContent;
    }

    private static function arrayToCsvString(array $fields): string
    {
        $f = fopen('php://memory', 'r+');
        if (fputcsv($f, $fields) === false) {
            return false;
        }
        rewind($f);
        $csv_line = stream_get_contents($f);

        return rtrim($csv_line);
    }
}
