<?php

namespace App\Domain\Service\HotelFileConvertService;

use App\Domain\BusinessConstraint\HotelBusinessConstraintValidator;
use App\Domain\Service\HotelFileConvertService\Parsers\IStrategyHotelFileParser;
use App\Domain\Service\HotelFileConvertService\Parsers\StrategyJsonHotelFileParser;
use App\Domain\Service\HotelFileConvertService\Parsers\StrategyXmlHotelFileParser;
use Exception;

class HotelFileConvertService
{
    private $strategy;
    private $fileContent;
    private $hotelBusinessConstraintValidator;

    public function __construct(
        HotelBusinessConstraintValidator $hotelBusinessConstraintValidator
    ) {
        $this->hotelBusinessConstraintValidator = $hotelBusinessConstraintValidator;
    }

    private function getStrategyAccordingFileExtension($filePath): IStrategyHotelFileParser
    {
        $filePathInfo = pathinfo($filePath);
        $extension = $filePathInfo['extension'];
        switch ($extension) {
            case "json";
                return new StrategyJsonHotelFileParser($this->fileContent, $this->hotelBusinessConstraintValidator);

            case "xml":
                return new StrategyXmlHotelFileParser($this->fileContent, $this->hotelBusinessConstraintValidator);

            default:
                throw new Exception("Was not possible get the strategy to this file extention: '$extension'");
        }
    }

    public function openFile($filePath): void
    {
        if (!file_exists($filePath)) {
            throw new Exception("Was not possible open the file: '$filePath'");
        }
        $this->fileContent = file_get_contents($filePath);
        $this->strategy = $this->getStrategyAccordingFileExtension($filePath);
    }

    public function getHotels(): array
    {
        if ($this->strategy == null) {
            throw new Exception("Was not possible to get hotels because don't have defined strategy yet.");
        }

        return $this->strategy->getHotels();
    }
}
