<?php

namespace App\Domain\Service\HotelFileConvertService\Filters;

use App\Domain\Model\HotelModel;

function filterHotelWithStarsBiggerOrEqualsThan(int $stars): callable
{
    return function (HotelModel $hotelModel) use ($stars): bool {
        return $hotelModel->getStars() >= $stars;
    };
};
