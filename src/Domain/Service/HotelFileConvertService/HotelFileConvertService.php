<?php

namespace App\Domain\Service\HotelFileConvertService;

use App\Domain\BusinessConstraint\HotelBusinessConstraintValidator;
use App\Domain\Service\HotelFileConvertService\Converters\IStrategyHotelFileConverter;
use App\Domain\Service\HotelFileConvertService\Converters\StrategyCsvHotelFileConverter;
use App\Domain\Service\HotelFileConvertService\Parsers\IStrategyHotelFileParser;
use App\Domain\Service\HotelFileConvertService\Parsers\StrategyJsonHotelFileParser;
use App\Domain\Service\HotelFileConvertService\Parsers\StrategyXmlHotelFileParser;
use Exception;
use Psr\Log\LoggerInterface;

class HotelFileConvertService
{
    private $inputFileStrategy;
    private $fileContent;
    private $hotelBusinessConstraintValidator;
    private $logger;

    public function __construct(
        HotelBusinessConstraintValidator $hotelBusinessConstraintValidator,
        LoggerInterface $logger
    ) {
        $this->hotelBusinessConstraintValidator = $hotelBusinessConstraintValidator;
        $this->logger = $logger;
    }

    private function getInputFileStrategy($sourceFilePath): IStrategyHotelFileParser
    {
        $sourceFilePathInfo = pathinfo($sourceFilePath);
        $inputFileExtension = $sourceFilePathInfo['extension'];
        switch ($inputFileExtension) {
            case "json";
                return new StrategyJsonHotelFileParser($this->fileContent, $this->hotelBusinessConstraintValidator);

            case "xml":
                return new StrategyXmlHotelFileParser($this->fileContent, $this->hotelBusinessConstraintValidator);

            default:
                throw new Exception("Was not possible get the strategy to this file extention: '$inputFileExtension'");
        }
    }

    private function getOutputFileStrategy(string $outputFilePath): IStrategyHotelFileConverter
    {
        $outputFilePathInfo = pathinfo($outputFilePath);
        $outputFileExtension = $outputFilePathInfo['extension'];

        switch ($outputFileExtension) {
            case "csv":
                return new StrategyCsvHotelFileConverter();

            default:
                throw new Exception("Was not possible get the strategy to this file extention: '$outputFileExtension'");
        }
    }

    private function getHotels(callable $filter = null): array
    {
        if ($this->inputFileStrategy == null) {
            throw new Exception("Was not possible to get hotels because don't have defined strategy yet.");
        }

        return $this->inputFileStrategy->getHotels($filter);
    }

    public function openFile(string $sourceFilePath): void
    {
        if (!file_exists($sourceFilePath)) {
            throw new Exception("Was not possible open the file: '$sourceFilePath'");
        }
        $this->fileContent = file_get_contents($sourceFilePath);
        $this->inputFileStrategy = $this->getInputFileStrategy($sourceFilePath);
    }

    public function convert(string $outputFilePath, callable $filter = null): void
    {
        $outputFileStrategy = $this->getOutputFileStrategy($outputFilePath);
        $hotels = $this->getHotels($filter);
        $totalHotels = count($hotels);

        $this->logger->notice("Starting conversion of $totalHotels valid hotels.");

        $outputFilePointer = fopen($outputFilePath, 'w');
        foreach ($outputFileStrategy->convert($hotels) as $hotelCsvLine) {
            fwrite($outputFilePointer, $hotelCsvLine);
        }
        fclose($outputFilePointer);
    }
}
