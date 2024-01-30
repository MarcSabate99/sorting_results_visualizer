<?php

namespace App\Tests\unit\Infrastructure\Exception;

use App\Infrastructure\Exception\RequestBodyValidationException;
use PHPUnit\Framework\TestCase;

class RequestBodyValidationExceptionTest extends TestCase
{
    private const EXPECTED_MESSAGE = 'Parameter example is required';

    public function testException()
    {
        $exception = RequestBodyValidationException::ofRequiredParam('example');
        $this->assertEquals(self::EXPECTED_MESSAGE, $exception->getMessage());
    }
}
