<?php

namespace App\Domain\BusinessConstraint;

use Psr\Log\LoggerInterface;

class HotelBusinessConstraintValidator implements IBusinessConstraintValidator
{
    private $logger;
    private $errors = [];

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    private function validateRequiredField(string $value, $fieldName): void
    {
        $trimValue = trim($value);
        if (empty($trimValue)) {
            $this->errors[] = "The hotel $fieldName is required.";
        }
    }

    private function validateASCII(string $value, $fieldName): void
    {
        if (!mb_detect_encoding($value, 'ASCII', true)) {
            $this->errors[] = "The hotel $fieldName with value: '$value' may not contain non-ASCII characters.";
        }
    }

    private function validateStars(int $stars): void
    {
        if ($stars < 0 || $stars > 5) {
            $this->errors[] = "The hotel stars '$stars' is invalid. Hotel ratings may be from 0 to 5 stars";
        }
    }

    private function validateValidUri(string $uri): void
    {
        if (filter_var($uri, FILTER_VALIDATE_URL) === false) {
            $this->errors[] = "The hotel uri '{$uri}' is not a valid URL.";
        }
    }

    private function clearErros(): void
    {
        $this->errors = [];
    }

    public function validate(int $index, $model): array
    {
        $this->clearErros();

        $this->validateASCII($model->getName(), "name");
        $this->validateASCII($model->getContact(), "contact");
        $this->validateASCII($model->getAddress(), "address");
        $this->validateRequiredField($model->getName(), "name");
        $this->validateRequiredField($model->getAddress(), "address");
        $this->validateRequiredField($model->getContact(), "contact");
        $this->validateRequiredField($model->getPhone(), "phone");
        $this->validateRequiredField($model->getUri(), "uri");
        $this->validateValidUri($model->getUri());
        $this->validateStars($model->getStars());

        if ($this->hasErrors()) {
            $this->logValidationWarning($index);
        }

        return $this->errors;
    }

    private function logValidationWarning(int $index)
    {
        foreach ($this->errors as $error) {
            $this->logger->error($error, ['dataIndex' => $index]);
        }
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }
}
