<?php

namespace App\Tests\Helpers;

use App\Domain\Model\HotelModel;

class HotelModelMother
{
    public static function createTwoValidHotelModels(): array
    {
        return [
            new HotelModel(
                "The Gibson",
                "63847 Lowe Knoll, East Maxine, WA 97030-4876",
                5,
                "Dr. Sinda Wyman",
                "1-270-665-9933x1626",
                "http://www.paucek.com/search.htm"
            ),
            new HotelModel(
                "Martini Cattaneo",
                "Stretto Bernardi 004, Quarto Mietta nell'emilia, 07958 Torino (OG)",
                4,
                "Rosalino Marchetti",
                "+39 627 68225719",
                "http://www.farina.org/blog/categories/tags/about.html"
            )
        ];
    }
}
