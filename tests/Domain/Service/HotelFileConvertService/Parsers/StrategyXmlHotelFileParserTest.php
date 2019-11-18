<?php

namespace App\Tests\Domain\Service\HotelFileConvertService\Parsers;

use App\Domain\BusinessConstraint\HotelBusinessConstraintValidator;
use App\Domain\Service\HotelFileConvertService\Parsers\StrategyXmlHotelFileParser;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class StrategyXmlHotelFileParserTest extends TestCase
{
    private $validator;

    public function __construct()
    {
        $this->validator = new HotelBusinessConstraintValidator($this->createMock(LoggerInterface::class));

        parent::__construct();
    }

    public function testGetHotels_ShouldReturnListOfHotelModelWithTwoItems_WhenConvertAXmlFileWithTwoHotels()
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
    <address>Stretto Bernardi 004, Quarto Mietta nell'emilia, 07958 Torino (OG)</address>
    <stars>5</stars>
    <contact>Rosalino Marchetti</contact>
    <phone>+39 627 68225719</phone>
    <uri>http://www.farina.org/blog/categories/tags/about.html</uri>
</hotel>
</hotels>
XML;
        $strategyXmlHotelFileParser = new StrategyXmlHotelFileParser($hotelsXml, $this->validator);
        $hotels = $strategyXmlHotelFileParser->getHotels();
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
        $hotelsXml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<hotels>
<hotel>
    <name>The Gibson</name>
    <address>63847 Lowe Knoll</address>
    <stars>5</stars>
    <contact>Dr. Sinda Wyman</contact>
    <phone>1-270-665-9933x1626</phone>
    <uri>It's an invaalid uri</uri>
</hotel>
<hotel>
    <name>Martini Cattaneo</name>
    <address>Stretto Bernardi 004, Quarto Mietta nell'emilia, 07958 Torino (OG)</address>
    <stars>5</stars>
    <contact>Rosalino Marchetti</contact>
    <phone>+39 627 68225719</phone>
    <uri>http://www.farina.org/blog/categories/tags/about.html</uri>
</hotel>
</hotels>
XML;

        $strategyXmlHotelFileParser = new StrategyXmlHotelFileParser($hotelsXml, $this->validator);
        $hotels = $strategyXmlHotelFileParser->getHotels();
        $this->assertCount(1, $hotels);
        $this->assertEquals("http://www.farina.org/blog/categories/tags/about.html", $hotels[0]->getUri());
    }

    public function testGetHotels_ShouldReturnEmptyList_WhenThereAreNoHotelsOnXmlFile()
    {
        $emptyHotelsXml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<hotels></hotels>     
XML;
        $strategyXmlHotelFileParser = new StrategyXmlHotelFileParser($emptyHotelsXml, $this->validator);
        $hotels = $strategyXmlHotelFileParser->getHotels();
        $this->assertCount(0, $hotels);
    }
}
