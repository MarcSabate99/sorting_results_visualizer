<?php


namespace App\Infrastructure\Exception;


use Exception;

class RequestBodyValidationException extends Exception
{
    public static function ofRequiredParam(string $parameter) {
        $message = sprintf("Parameter %s is required", $parameter);
        return new self($message);
    }
}