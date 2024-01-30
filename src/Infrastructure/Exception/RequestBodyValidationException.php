<?php

declare(strict_types=1);

namespace App\Infrastructure\Exception;

class RequestBodyValidationException extends \Exception
{
    public static function ofRequiredParam(string $parameter): self
    {
        $message = sprintf('Parameter %s is required', $parameter);

        return new self($message);
    }
}
