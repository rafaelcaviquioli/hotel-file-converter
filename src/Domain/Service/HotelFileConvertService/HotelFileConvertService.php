<?php

namespace App\Domain\Service\HotelFileConvertService;

use Exception;

class HotelFileConvertService
{
    private $strategy;
    private $fileContent;

    private function getStrategyAccordingFileExtension($filePath): IStrategyHotelFileParser
    {
        $filePathInfo = pathinfo($filePath);
        $extension = $filePathInfo['extension'];
        switch ($extension) {
            case "json";
                return new StrategyJsonFileParser($this->fileContent);

            case "xml":
                return new StrategyXmlFileParser($this->fileContent);

            default:
                throw new Exception("Was not possible get the strategy to this file extention: '$extension'");
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
