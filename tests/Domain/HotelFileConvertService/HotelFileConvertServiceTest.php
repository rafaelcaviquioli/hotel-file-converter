<?php

namespace App\Tests\Domain\HotelFileConvertService;

use App\Domain\BusinessConstraint\HotelBusinessConstraintValidator;
use App\Domain\Service\HotelFileConvertService\HotelFileConvertService;
use Exception;
use PHPUnit\Framework\TestCase;

class HotelFileConvertServiceTest extends TestCase
{
    public function testGetHotels_ShoudThrowException_WhenDontHaveDefinedStrategy()
    {
        $hotelFileConvertService = new HotelFileConvertService(new HotelBusinessConstraintValidator);
        $this->expectException(Exception::class);
        $hotelFileConvertService->getHotels();
    }
}
