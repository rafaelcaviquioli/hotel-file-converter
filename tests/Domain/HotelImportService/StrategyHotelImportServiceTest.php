<?php

namespace App\Tests\Domain\HotelImportService;

use App\Domain\Service\HotelImportService\StrategyHotelImportService;
use Exception;
use PHPUnit\Framework\TestCase;

class StrategyHotelImportServiceTest extends TestCase
{
    public function testGetHotels_ShoudThrowException_WhenDontHaveDefinedStrategy()
    {
        $strategy = new StrategyHotelImportService();
        $this->expectException(Exception::class);
        $strategy->getHotels();
    }
}
