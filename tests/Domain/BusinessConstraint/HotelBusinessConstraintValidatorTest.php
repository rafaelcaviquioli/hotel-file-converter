<?php

namespace App\Tests\Domain\BusinessConstraint;

use App\Domain\BusinessConstraint\HotelBusinessConstraintValidator;
use App\Domain\Model\HotelModel;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class HotelBusinessConstraintValidatorTest extends TestCase
{
    private $logger;

    public function __construct()
    {
        $this->logger = $this->createMock(LoggerInterface::class);

        parent::__construct();
    }
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

        $validator = new HotelBusinessConstraintValidator($this->logger);
        $errors = $validator->validate(1, $hotelModel);

        $this->assertEmpty($errors);
        $this->assertFalse($validator->hasErrors());
    }
    public function testHasErrors_ShoudReturnTrue_WhenHotelModelContainValidationErrors()
    {
        $hotelModelTenStars = new HotelModel("", "", -1, "", "", "");
        $validator = new HotelBusinessConstraintValidator($this->logger);
        $errors = $validator->validate(1, $hotelModelTenStars);

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

        $validator = new HotelBusinessConstraintValidator($this->logger);
        $errors = $validator->validate(1, $hotelModel);

        $this->assertCount(1, $errors);
        $this->assertEquals("The hotel name 'Hostel Rinaldí' may not contain non-ASCII characters.", $errors[0]);
    }

    public function testGetValidateErrors_ShoudRegisterLogError_WhenHotelNameIsNotValid()
    {
        $hotelModel = new HotelModel(
            "Hostel Rinaldí",
            "Via Sala 62 Piano 9, Anselmo umbro, 67695 Pisa (AO)",
            3,
            "The Timothy Ferrari",
            "+39 168 21539395",
            "http://www.hostel.biz/post.htm"
        );

        $loggerMock = $this->createMock(LoggerInterface::class);
        $loggerMock
            ->expects($this->once())
            ->method('error')
            ->with(
                $this->equalTo("The hotel name 'Hostel Rinaldí' may not contain non-ASCII characters."),
                $this->equalTo(['dataIndex' => 1])
            );

        $validator = new HotelBusinessConstraintValidator($loggerMock);
        $validator->validate(1, $hotelModel);
    }

    public function testGetValidateErrors_ShoudNotRegisterErrorLog_WhenHotelModelIsValid()
    {
        $hotelModel = new HotelModel(
            "Hostel Rinaldi",
            "Via Sala 62 Piano 9, Anselmo umbro, 67695 Pisa (AO)",
            3,
            "The Timothy Ferrari",
            "+39 168 21539395",
            "http://www.hostel.biz/post.htm"
        );

        $loggerMock = $this->createMock(LoggerInterface::class);
        $loggerMock
            ->expects($this->never())
            ->method('error');

        $validator = new HotelBusinessConstraintValidator($loggerMock);
        $validator->validate(1, $hotelModel);
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

        $validator = new HotelBusinessConstraintValidator($this->logger);
        $errors = $validator->validate(1, $hotelModel);

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

        $validator = new HotelBusinessConstraintValidator($this->logger);
        $errors = $validator->validate(1, $hotelModel);

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

        $validator = new HotelBusinessConstraintValidator($this->logger);
        $errors = $validator->validate(1, $hotelModelTenStars);

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

        $validator = new HotelBusinessConstraintValidator($this->logger);
        $errors = $validator->validate(1, $hotelModelTenStars);

        $this->assertCount(1, $errors);
        $this->assertEquals("The hotel stars '-1' is invalid. Hotel ratings may be from 0 to 5 stars", $errors[0]);
    }
}
