<?php

namespace App\Domain\BusinessConstraint;

class HotelBusinessConstraintValidator implements IBusinessConstraintValidator
{
    private $errors = [];

    private function validateName(string $name): void
    {
        if (!mb_detect_encoding($name, 'ASCII', true)) {
            $this->errors[] = "The hotel name '$name' may not contain non-ASCII characters.";
        }
    }
    private function validateRequiredUri(string $uri): void
    {
        $uriTrim = $uri;

        if (empty($uriTrim)) {
            $this->errors[] = "The hotel uri is required.";
        }
    }
    private function validateValidUri(string $uri): void
    {
        if (filter_var($uri, FILTER_VALIDATE_URL) === false) {
            $this->errors[] = "The hotel uri '{$uri}' is not a valid URL.";
        }
    }
    private function validateStars(int $stars): void
    {
        if ($stars < 0 || $stars > 5) {
            $this->errors[] = "The hotel stars '$stars' is invalid. Hotel ratings may be from 0 to 5 stars";
        }
    }

    private function clearErros(): void
    {
        $this->errors = [];
    }

    public function validate($model) : array
    {
        $this->clearErros();

        $this->validateName($model->getName());
        $this->validateValidUri($model->getUri());
        $this->validateRequiredUri($model->getUri());
        $this->validateStars($model->getStars());

        return $this->errors;
    }
}
