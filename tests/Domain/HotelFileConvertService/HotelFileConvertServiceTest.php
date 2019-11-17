<?php

namespace App\Tests\Domain\HotelFileConvertService;

use App\Domain\BusinessConstraint\HotelBusinessConstraintValidator;
use App\Domain\Service\HotelFileConvertService\HotelFileConvertService;
use Exception;
use PHPUnit\Framework\TestCase;

class HotelFileConvertServiceTest extends TestCase
{
    public function testConvert_ShoudThrowException_WhenDontHaveDefinedStrategy()
    {
        $hotelFileConvertService = new HotelFileConvertService(new HotelBusinessConstraintValidator);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Was not possible to get hotels because don't have defined strategy yet.");
        $hotelFileConvertService->convert("./whateverOutputFile.csv");
    }

    public function testOpenFile_shouldThrowException_WhenTryToOpenAnNonexistentInputFile()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Was not possible open the file: './nonexistentInputFile.json'");
        
        $hotelFileConvertService = new HotelFileConvertService(new HotelBusinessConstraintValidator);
        $hotelFileConvertService->openFile("./nonexistentInputFile.json");
    }
    
    public function testConvert_ShoudCreateACsvFileWithHotels_WhenInputJsonFileHasHotels()
    {
        /* Prepara data */
        $inputFilePath = HotelFileTestHelper::createTempHotelJsonFileWithTwoValidHotels();
        $outputFilePath = sys_get_temp_dir() . "/hotels-output-" . microtime() . ".csv";

        /* Use case execution */
        $hotelFileConvertService = new HotelFileConvertService(new HotelBusinessConstraintValidator);
        $hotelFileConvertService->openFile($inputFilePath);
        $hotelFileConvertService->convert($outputFilePath);

        /* Define expectations */
        $hotelsCsv = file_get_contents($outputFilePath);
        $csvArrayLines = explode(PHP_EOL, $hotelsCsv);
        $expectLine1 = '"The Gibson","63847 Lowe Knoll, East Maxine, WA 97030-4876",5,"Dr. Sinda Wyman",1-270-665-9933x1626,http://www.paucek.com/search.htm';
        $expectLine2 = '"Martini Cattaneo","Stretto Bernardi 004, Quarto Mietta nell\'emilia, 07958 Torino (OG)",4,"Rosalino Marchetti","+39 627 68225719",http://www.farina.org/blog/categories/tags/about.html';

        /* Delete temporary files */
        unlink($inputFilePath);
        unlink($outputFilePath);

        /* Assert results */
        $this->assertEquals($expectLine1, $csvArrayLines[0]);
        $this->assertEquals($expectLine2, $csvArrayLines[1]);
        $this->assertEquals("", $csvArrayLines[2]);
        $this->assertCount(3, $csvArrayLines);
    }
}
