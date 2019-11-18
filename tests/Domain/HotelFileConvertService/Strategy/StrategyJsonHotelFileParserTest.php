<?php

namespace App\Tests\HotelFileConvertService;

use App\Domain\BusinessConstraint\HotelBusinessConstraintValidator;
use App\Domain\Service\HotelFileConvertService\Parsers\StrategyJsonHotelFileParser;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class StrategyJsonHotelFileParserTest extends TestCase
{
    private $validator;

    public function __construct()
    {
        $this->validator = new HotelBusinessConstraintValidator($this->createMock(LoggerInterface::class));

        parent::__construct();
    }
    public function testGetHotels_ShouldReturnListOfHotelModelWithTwoItems_WhenConvertAJsonFileWithTwoHotels()
    {
        $hotelsJson = <<<JSON
[
    {
        "name": "The Gibson",
        "address": "63847 Lowe Knoll",
        "stars": "5",
        "contact": "Dr. Sinda Wyman",
        "phone": "1-270-665-9933x1626",
        "uri": "http:\/\/www.paucek.com\/search.htm"
    },
    {
        "name": "Martini Cattaneo",
        "address": "Stretto Bernardi 004, Quarto Mietta nell'emilia, 07958 Torino (OG)",
        "stars": "5",
        "contact": "Rosalino Marchetti",
        "phone": "+39 627 68225719",
        "uri": "http:\/\/www.farina.org\/blog\/categories\/tags\/about.html"
    }
]
JSON;
        $strategyJsonHotelFileParser = new StrategyJsonHotelFileParser($hotelsJson, $this->validator);
        $hotels = $strategyJsonHotelFileParser->getHotels();
        $this->assertCount(2, $hotels);
        $this->assertEquals("The Gibson", $hotels[0]->getName());
        $this->assertEquals("63847 Lowe Knoll", $hotels[0]->getAddress());
        $this->assertEquals("5", $hotels[0]->getStars());
        $this->assertEquals("Dr. Sinda Wyman", $hotels[0]->getContact());
        $this->assertEquals("1-270-665-9933x1626", $hotels[0]->getPhone());
        $this->assertEquals("http://www.paucek.com/search.htm", $hotels[0]->getUri());
    }

    public function testGetHotels_ShouldNotConvertAnInvalidHotel_WhenItHasAnInvalidUri()
    {
        $hotelsJson = <<<JSON
[
    {
        "name": "The Gibson",
        "address": "63847 Lowe Knoll",
        "stars": "5",
        "contact": "Dr. Sinda Wyman",
        "phone": "1-270-665-9933x1626",
        "uri": "that's an invalid uri"
    },
    {
        "name": "Martini Cattaneo",
        "address": "Stretto Bernardi 004, Quarto Mietta nell'emilia, 07958 Torino (OG)",
        "stars": "5",
        "contact": "Rosalino Marchetti",
        "phone": "+39 627 68225719",
        "uri": "http:\/\/www.farina.org\/blog\/categories\/tags\/about.html"
    }
]
JSON;
        $strategyJsonHotelFileParser = new StrategyJsonHotelFileParser($hotelsJson, $this->validator);
        $hotels = $strategyJsonHotelFileParser->getHotels();
        $this->assertCount(1, $hotels);
        $this->assertEquals("http://www.farina.org/blog/categories/tags/about.html", $hotels[0]->getUri());
    }

    public function testGetHotels_ShouldReturnEmptyList_WhenThereAreNoHotelsOnJsonFile()
    {
        $emptyHotelsJson = "[]";
        $strategyJsonHotelFileParser = new StrategyJsonHotelFileParser($emptyHotelsJson, $this->validator);
        $hotels = $strategyJsonHotelFileParser->getHotels();
        $this->assertCount(0, $hotels);
    }
}
