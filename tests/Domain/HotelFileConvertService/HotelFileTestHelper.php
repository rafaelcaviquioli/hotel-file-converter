<?php

namespace App\Tests\Domain\HotelFileConvertService;

class HotelFileTestHelper
{
    public static function createTempHotelJsonFileWithTwoValidHotels(): string
    {
        $hotelsJson = <<<JSON
        [
            {
                "name": "The Gibson",
                "address": "63847 Lowe Knoll, East Maxine, WA 97030-4876",
                "stars": "5",
                "contact": "Dr. Sinda Wyman",
                "phone": "1-270-665-9933x1626",
                "uri": "http:\/\/www.paucek.com\/search.htm"
            },
            {
                "name": "Martini Cattaneo",
                "address": "Stretto Bernardi 004, Quarto Mietta nell'emilia, 07958 Torino (OG)",
                "stars": "4",
                "contact": "Rosalino Marchetti",
                "phone": "+39 627 68225719",
                "uri": "http:\/\/www.farina.org\/blog\/categories\/tags\/about.html"
            }
        ]
JSON;
        $inputFilePath = sys_get_temp_dir() . "/hotels-input-" . microtime() . ".json";
        file_put_contents($inputFilePath, $hotelsJson);

        return $inputFilePath;
    }
}
