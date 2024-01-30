<?php

namespace App\Tests\unit\Domain\Exception;

use App\Domain\Exception\DataValidationException;
use PHPUnit\Framework\TestCase;

class DataValidationExceptionTest extends TestCase
{
    private const EXPECTED_MESSAGE = 'Field example is required';

    public function testException()
    {
        $exception = DataValidationException::ofRequiredField('example');
        $this->assertEquals(self::EXPECTED_MESSAGE, $exception->getMessage());
    }
}
