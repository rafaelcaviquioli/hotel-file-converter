<?php

namespace App\Domain\BusinessConstraint;

use App\Domain\Model\HotelModel;

class ValidateHotelBusinessConstraint implements IValidateBusinessConstraint
{
    private $errors = [];

    private function validateName(string $name): void
    {
        if (!mb_detect_encoding($name, 'ASCII', true)) {
            $this->errors[] = "The hotel name '$name' may not contain non-ASCII characters.";
        }
    }
    private function validateValidUri(string $uri): void
    {
        $uriTrim = $uri;

        if (empty($uriTrim)) {
            $this->errors[] = "The hotel uri is required.";
        }
    }
    private function validateRequiredUri(string $uri): void
    {
        if (filter_var($uri, FILTER_VALIDATE_URL) === false) {
            $this->errors[] = "The hotel uri '{$uri}' is not a valid URL.";
        }
    }
    private function validateStars(int $stars): void
    {
        if ($stars < 0 || $stars > 5) {
            $this->errors[] = "The stars '$stars' is invalid";
        }
    }

    private function clearErros(): void
    {
        $this->errors = [];
    }

    public function getValidateErrors($model) : array
    {
        $this->clearErros();

        $this->validateName($model->getName());
        $this->validateValidUri($model->getUri());
        $this->validateRequiredUri($model->getUri());
        $this->validateStars($model->getStars());

        return $this->errors;
    }
}
