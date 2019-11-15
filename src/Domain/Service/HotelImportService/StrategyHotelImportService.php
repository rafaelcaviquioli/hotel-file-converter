<?php

namespace App\Domain\Service\HotelImportService;

use Exception;

class StrategyHotelImportService
{
    private $strategy;

    private function getStrategyAccordingFileExtension($filePath): IStrategyHotelFileParser
    {
        $filePathInfo = pathinfo($filePath);
        $extension = $filePathInfo['extension'];
        switch ($extension) {
            case "json";
                return new StrategyJsonFileParser($filePath);

            case "xml":
                return new StrategyXmlFileParser($filePath);

            default:
                throw new Exception("Was not possible get the strategy to this file extention: '$fileExtension'");
        }
    }

    private function validateFileExists($filePath)
    {
        if (!file_exists($filePath)) {
            throw new Exception("Was not possible open the file: '$filePath'");
        }
    }

    public function openFile($filePath): void
    {
        $this->validateFileExists($filePath);

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
