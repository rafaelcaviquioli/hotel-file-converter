<?php

namespace App\Tests\Domain\Service\HotelFileConvertService;

use App\Tests\Helpers\HotelModelMother;
use PHPUnit\Framework\TestCase;
use function App\Domain\Service\HotelFileConvertService\Filters\filterHotelWithStarsBiggerOrEqualsThan;

class FilterHotelWithStarsBiggerThanTest extends TestCase
{
    public function testFilterHotelWithStarsBiggerOrEqualsThan_ShouldFilterHotelsThatContainsFourOrMoreStars()
    {
        $hotels = [
            HotelModelMother::createAValidHotelAndSetStars(1),
            HotelModelMother::createAValidHotelAndSetStars(2),
            HotelModelMother::createAValidHotelAndSetStars(3),
            HotelModelMother::createAValidHotelAndSetStars(4),
            HotelModelMother::createAValidHotelAndSetStars(5),
        ];

        $hotelsFiltered = array_filter($hotels, filterHotelWithStarsBiggerOrEqualsThan(4));

        $this->assertCount(2, $hotelsFiltered);
        $this->assertArrayNotHasKey(0, $hotelsFiltered);
        $this->assertArrayNotHasKey(1, $hotelsFiltered);
        $this->assertArrayNotHasKey(2, $hotelsFiltered);
        $this->assertEquals(4, $hotelsFiltered[3]->getStars());
        $this->assertEquals(5, $hotelsFiltered[4]->getStars());
    }
}
