<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class DataValidationException extends \Exception
{
    public static function ofRequiredField(string $requiredField): self
    {
        $message = sprintf('Field %s is required', $requiredField);

        return new self($message);
    }
}
