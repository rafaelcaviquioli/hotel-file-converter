<?php

namespace App\Tests\Helpers;

class HotelFileTestHelper
{
    public static function createTempHotelJsonFileWithTwoValidHotels(): string
    {
        $hotelsJson = <<<JSON
        [
            {
                "name": "The Gibson",
                "address": "63847 Lowe Knoll, East Maxine, WA 97030-4876",
                "stars": 5,
                "contact": "Dr. Sinda Wyman",
                "phone": "1-270-665-9933x1626",
                "uri": "http:\/\/www.paucek.com\/search.htm"
            },
            {
                "name": "Martini Cattaneo",
                "address": "Stretto Bernardi 004, Quarto Mietta nell'emilia, 07958 Torino (OG)",
                "stars": 4,
                "contact": "Rosalino Marchetti",
                "phone": "+39 627 68225719",
                "uri": "http:\/\/www.farina.org\/blog\/categories\/tags\/about.html"
            }
        ]
JSON;
        $sourceFilePath = sys_get_temp_dir() . "/hotels-source-" . microtime() . ".json";
        file_put_contents($sourceFilePath, $hotelsJson);

        return $sourceFilePath;
    }
    public static function createTempHotelJsonFileEmpty(): string
    {
        $hotelsJson = <<<JSON
        []
JSON;
        $sourceFilePath = sys_get_temp_dir() . "/hotels-source-empty-" . microtime() . ".json";
        file_put_contents($sourceFilePath, $hotelsJson);

        return $sourceFilePath;
    }
    public static function createTempHotelXmlFileWithTwoValidHotels(): string
    {
        $hotelsXml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<hotels>
<hotel>
    <name>The Gibson</name>
    <address>63847 Lowe Knoll</address>
    <stars>5</stars>
    <contact>Dr. Sinda Wyman</contact>
    <phone>1-270-665-9933x1626</phone>
    <uri>http://www.paucek.com/search.htm</uri>
</hotel>
<hotel>
    <name>Martini Cattaneo</name>
    <address>Stretto Bernardi 004</address>
    <stars>5</stars>
    <contact>Rosalino Marchetti</contact>
    <phone>+39 627 68225719</phone>
    <uri>http://www.farina.org/blog/categories/tags/about.html</uri>
</hotel>
</hotels>
XML;
        $sourceFilePath = sys_get_temp_dir() . "/hotels-source-" . microtime() . ".xml";
        file_put_contents($sourceFilePath, $hotelsXml);

        return $sourceFilePath;
    }
    public static function createTempHotelXmlFileEmpty(): string
    {
        $hotelsJson = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<hotels></hotels>
XML;
        $sourceFilePath = sys_get_temp_dir() . "/hotels-source-empty-" . microtime() . ".xml";
        file_put_contents($sourceFilePath, $hotelsJson);

        return $sourceFilePath;
    }
}
