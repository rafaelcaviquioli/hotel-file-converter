<?php

namespace App\Tests\Domain\HotelFileConvertService;

use App\Domain\Service\HotelFileConvertService\StrategyJsonHotelFileParser;
use Exception;
use PHPUnit\Framework\TestCase;

class StrategyJsonHotelFileParserTest extends TestCase
{
    public function testGetHotels_ShouldReturnListOfHotelModelWithTwoItems_WhenConvertAJsonFileWithTwoHotels()
    {
        $hotelsJson = "
        [
            {
                \"name\": \"The Gibson\",
                \"address\": \"63847 Lowe Knoll\",
                \"stars\": \"5\",
                \"contact\": \"Dr. Sinda Wyman\",
                \"phone\": \"1-270-665-9933x1626\",
                \"uri\": \"http:\/\/www.paucek.com\/search.htm\"
            },
            {
                \"name\": \"Martini Cattaneo\",
                \"address\": \"Stretto Bernardi 004, Quarto Mietta nell'emilia, 07958 Torino (OG)\",
                \"stars\": \"5\",
                \"contact\": \"Rosalino Marchetti\",
                \"phone\": \"+39 627 68225719\",
                \"uri\": \"http:\/\/www.farina.org\/blog\/categories\/tags\/about.html\"
            }
        ]
        ";
        $strategyJsonHotelFileParser = new StrategyJsonHotelFileParser($hotelsJson);
        $hotels = $strategyJsonHotelFileParser->getHotels();
        $this->assertCount(2, $hotels);
        $this->assertEquals("The Gibson", $hotels[0]->getName());
        $this->assertEquals("63847 Lowe Knoll", $hotels[0]->getAddress());
        $this->assertEquals("5", $hotels[0]->getStars());
        $this->assertEquals("Dr. Sinda Wyman", $hotels[0]->getContact());
        $this->assertEquals("1-270-665-9933x1626", $hotels[0]->getPhone());
        $this->assertEquals("http://www.paucek.com/search.htm", $hotels[0]->getUri());
    }
}
