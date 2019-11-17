<?php

namespace App\Tests\Domain\BusinessConstraint;

use App\Domain\BusinessConstraint\HotelBusinessConstraintValidator;
use App\Domain\Model\HotelModel;
use PHPUnit\Framework\TestCase;

class HotelBusinessConstraintValidatorTest extends TestCase
{
    public function testGetValidateErrors_ShoudReturnNoErrors_WhenHotelModelIsValid()
    {
        $hotelModel = new HotelModel(
            "Hostel Rinaldi",
            "Via Sala 62 Piano 9, Anselmo umbro, 67695 Pisa (AO)",
            3,
            "The Timothy Ferrari",
            "+39 168 21539395",
            "http://www.hostel.biz/post.htm"
        );

        $validator = new HotelBusinessConstraintValidator();
        $errors = $validator->validate($hotelModel);

        $this->assertEmpty($errors);
        $this->assertFalse($validator->hasErrors());
    }
    public function testHasErrors_ShoudReturnTrue_WhenHotelModelContainValidationErrors()
    {
        $hotelModelTenStars = new HotelModel("", "", -1, "", "", "");
        $validator = new HotelBusinessConstraintValidator();
        $errors = $validator->validate($hotelModelTenStars);

        $this->assertTrue($validator->hasErrors());
    }
    public function testGetValidateErrors_ShoudReturnHotelNameError_WhenHotelNameIsNotValid()
    {
        $hotelModel = new HotelModel(
            "Hostel Rinaldí",
            "Via Sala 62 Piano 9, Anselmo umbro, 67695 Pisa (AO)",
            3,
            "The Timothy Ferrari",
            "+39 168 21539395",
            "http://www.hostel.biz/post.htm"
        );

        $validator = new HotelBusinessConstraintValidator();
        $errors = $validator->validate($hotelModel);

        $this->assertCount(1, $errors);
        $this->assertEquals("The hotel name 'Hostel Rinaldí' may not contain non-ASCII characters.", $errors[0]);
    }
    public function testGetValidateErrors_ShoudReturnHotelUriErrors_WhenHotelUriIsEmptyAndWhenItIsInvalid()
    {
        $hotelModel = new HotelModel(
            "Hostel Rinaldi",
            "Via Sala 62 Piano 9, Anselmo umbro, 67695 Pisa (AO)",
            3,
            "The Timothy Ferrari",
            "+39 168 21539395",
            ""
        );

        $validator = new HotelBusinessConstraintValidator();
        $errors = $validator->validate($hotelModel);

        $this->assertCount(2, $errors);
        $this->assertEquals("The hotel uri '' is not a valid URL.", $errors[0]);
        $this->assertEquals("The hotel uri is required.", $errors[1]);
    }
    public function testGetValidateErrors_ShoudReturnInvalidHotelUriErrors_WhenHotelUriIsInvalid()
    {
        $hotelModel = new HotelModel(
            "Hostel Rinaldi",
            "Via Sala 62 Piano 9, Anselmo umbro, 67695 Pisa (AO)",
            3,
            "The Timothy Ferrari",
            "+39 168 21539395",
            "thisIsAnInvalidUri"
        );

        $validator = new HotelBusinessConstraintValidator();
        $errors = $validator->validate($hotelModel);

        $this->assertCount(1, $errors);
        $this->assertEquals("The hotel uri 'thisIsAnInvalidUri' is not a valid URL.", $errors[0]);
    }
    public function testGetValidateErrors_ShoudReturnInvalidStars_WhenHotelIsBiggerThanFiveStars()
    {
        $hotelModelTenStars = new HotelModel(
            "Hostel Rinaldi",
            "Via Sala 62 Piano 9, Anselmo umbro, 67695 Pisa (AO)",
            10,
            "The Timothy Ferrari",
            "+39 168 21539395",
            "http://www.hostel.biz/post.htm"
        );

        $validator = new HotelBusinessConstraintValidator();
        $errors = $validator->validate($hotelModelTenStars);

        $this->assertCount(1, $errors);
        $this->assertEquals("The hotel stars '10' is invalid. Hotel ratings may be from 0 to 5 stars", $errors[0]);
    }
    public function testGetValidateErrors_ShoudReturnInvalidStars_WhenHotelIsLesserThan1Star()
    {
        $hotelModelTenStars = new HotelModel(
            "Hostel Rinaldi",
            "Via Sala 62 Piano 9, Anselmo umbro, 67695 Pisa (AO)",
            -1,
            "The Timothy Ferrari",
            "+39 168 21539395",
            "http://www.hostel.biz/post.htm"
        );

        $validator = new HotelBusinessConstraintValidator();
        $errors = $validator->validate($hotelModelTenStars);

        $this->assertCount(1, $errors);
        $this->assertEquals("The hotel stars '-1' is invalid. Hotel ratings may be from 0 to 5 stars", $errors[0]);
    }
}
