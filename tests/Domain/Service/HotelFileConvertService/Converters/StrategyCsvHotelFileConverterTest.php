<?php

namespace App\Tests\Domain\Service\HotelFileConvertService\Parsers;

use App\Domain\Service\HotelFileConvertService\Converters\StrategyCsvHotelFileConverter;
use App\Tests\Helpers\HotelModelMother;
use PHPUnit\Framework\TestCase;

class StrategyCsvHotelFileConverterTest extends TestCase
{

    public function testConvert_ShoudCreateHotelsCsvFile_WhenConvertMethodIsCalledWithHotelsModel()
    {
        $hotels = HotelModelMother::createTwoValidHotelModels();
        $strategyCsvHotelFileConverter = new StrategyCsvHotelFileConverter();
        $iterator = $strategyCsvHotelFileConverter->convert($hotels);

        $expectLine1 = '"The Gibson","63847 Lowe Knoll, East Maxine, WA 97030-4876",5,"Dr. Sinda Wyman",1-270-665-9933x1626,http://www.paucek.com/search.htm';
        $expectLine2 = '"Martini Cattaneo","Stretto Bernardi 004, Quarto Mietta nell\'emilia, 07958 Torino (OG)",4,"Rosalino Marchetti","+39 627 68225719",http://www.farina.org/blog/categories/tags/about.html';

        $this->assertContains($expectLine1, $iterator->current());
        $iterator->next();

        $this->assertContains($expectLine2, $iterator->current());
        $iterator->next();

        $this->assertFalse($iterator->valid());
    }
}
