<?php

namespace App\Domain\Service\HotelFileConvertService\Filters;

use App\Domain\Model\HotelModel;

/*
 * The next line (12) is to avoid a unknown problema with:
 * "Compile Error: Cannot redeclare filterHotelWithStarsBiggerOrEqualsThan"
*/

if (!function_exists(__NAMESPACE__ . '\filterHotelWithStarsBiggerOrEqualsThan')) {

    function filterHotelWithStarsBiggerOrEqualsThan(int $stars): callable
    {
        return function (HotelModel $hotelModel) use ($stars): bool {
            return $hotelModel->getStars() >= $stars;
        };
    }
}
