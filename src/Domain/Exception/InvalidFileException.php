<?php


namespace App\Domain\Exception;

use Exception;

class InvalidFileException extends Exception
{
    public static function ofExtension(string $extension): Exception {
        return new self("Unsupported file type: $extension");
    }
}