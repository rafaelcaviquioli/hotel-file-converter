<?php

namespace App\Domain\Model;

class HotelModel
{
    private $name;
    private $address;
    private $stars;
    private $contact;
    private $phone;
    private $uri;

    public function __construct(
        $name,
        $address,
        $stars,
        $contact,
        $phone,
        $uri
    ) {
        $this->name = $name;
        $this->address = $address;
        $this->stars = $stars;
        $this->contact = $contact;
        $this->phone = $phone;
        $this->uri = $uri;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function getAddress(): string
    {
        return $this->address;
    }
    public function getStars(): int
    {
        return $this->stars;
    }
    public function getContact(): string
    {
        return $this->contact;
    }
    public function getPhone(): string
    {
        return $this->phone;
    }
    public function getUri(): string
    {
        return $this->uri;
    }
}
