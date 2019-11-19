<?php

namespace App\Tests\Command;

use App\Tests\Helpers\HotelFileTestHelper;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Tester\CommandTester;

class ConvertHotelsFileCommandTest extends KernelTestCase
{
    public function testExecute_ShouldConvertJsonHotelsFileToCsvFile()
    {
        /* Prepara data */
        $sourceFilePath = HotelFileTestHelper::createTempHotelJsonFileWithTwoValidHotels();
        $outputFilePath = sys_get_temp_dir() . "/hotels-output-" . microtime() . ".csv";

        /* Execute use case command */
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $command = $application->find('app:convert-hotels-file');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'sourceFilePath' => $sourceFilePath,
            'outputFilePath' => $outputFilePath,
        ]);

        /* Define expectations */
        $hotelsCsv = file_get_contents($outputFilePath);
        $csvArrayLines = explode(PHP_EOL, $hotelsCsv);
        $expectLine1 = '"The Gibson","63847 Lowe Knoll, East Maxine, WA 97030-4876",5,"Dr. Sinda Wyman",1-270-665-9933x1626,http://www.paucek.com/search.htm';
        $expectLine2 = '"Martini Cattaneo","Stretto Bernardi 004, Quarto Mietta nell\'emilia, 07958 Torino (OG)",4,"Rosalino Marchetti","+39 627 68225719",http://www.farina.org/blog/categories/tags/about.html';

        /* Delete temporary files */
        unlink($sourceFilePath);
        unlink($outputFilePath);

        /* Assert results */
        $this->assertEquals($expectLine1, $csvArrayLines[0]);
        $this->assertEquals($expectLine2, $csvArrayLines[1]);
        $this->assertEquals("", $csvArrayLines[2]);
        $this->assertCount(3, $csvArrayLines);
    }

    public function testExecute_ShouldRequireSourceAndOutputPathArguments()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "sourceFilePath, outputFilePath")');

        $kernel = static::createKernel();
        $application = new Application($kernel);
        $command = $application->find('app:convert-hotels-file');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
        ]);
    }

    public function testExecute_ShouldConvertOnlyHotelsWithStarsLevelBiggerOrEqualsTo5_WhenFilterOptionIsPassed()
    {
        /* Prepara data */
        $sourceFilePath = HotelFileTestHelper::createTempHotelJsonFileWithTwoValidHotels();
        $outputFilePath = sys_get_temp_dir() . "/hotels-output-" . microtime() . ".csv";

        /* Execute use case command */
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $command = $application->find('app:convert-hotels-file');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'sourceFilePath' => $sourceFilePath,
            'outputFilePath' => $outputFilePath,
            '--filterStarsBiggerOrEqualsThan' => 5
        ]);

        /* Define expectations */
        $hotelsCsv = file_get_contents($outputFilePath);
        $csvArrayLines = explode(PHP_EOL, $hotelsCsv);
        $expectLine = '"The Gibson","63847 Lowe Knoll, East Maxine, WA 97030-4876",5,"Dr. Sinda Wyman",1-270-665-9933x1626,http://www.paucek.com/search.htm';

        /* Delete temporary files */
        unlink($sourceFilePath);
        unlink($outputFilePath);

        /* Assert results */
        $this->assertEquals($expectLine, $csvArrayLines[0]);
        $this->assertEquals("", $csvArrayLines[1]);
        $this->assertCount(2, $csvArrayLines);
    }
}
