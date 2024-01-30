<?php

namespace App\Tests\unit\Domain\Service;

use App\Domain\Exception\DataValidationException;
use App\Domain\Service\DataValidator;
use PHPUnit\Framework\TestCase;

class DataValidatorTest extends TestCase
{
    private DataValidator $dataValidator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->dataValidator = new DataValidator();
    }

    /**
     * @dataProvider dataProviderWithoutException
     */
    public function testValidateWithoutException(array $data): void
    {
        $this->expectNotToPerformAssertions();
        $this->dataValidator->handle(
            $data
        );
    }

    /**
     * @dataProvider dataProviderWithException
     */
    public function testValidateWithException(array $data): void
    {
        $this->expectException(DataValidationException::class);
        $this->dataValidator->handle(
            $data
        );
    }

    public static function dataProviderWithException(): array
    {
        return [
            'data' => [
                [
                    [
                        'example' => 'Example',
                        'imageUrl' => 'Example',
                    ],
                ],
                [
                    [
                        'exampleTitle' => 'Example',
                        'imageUrl' => 'Example',
                        'otherField' => 'Example',
                    ],
                ],
            ],
        ];
    }

    public static function dataProviderWithoutException(): array
    {
        return [
            'data' => [
                [
                    [
                        'title' => 'Example',
                        'imageUrl' => 'Example',
                    ],
                ],
                [
                    [
                        'title' => 'Example',
                        'imageUrl' => 'Example',
                        'otherField' => 'Example',
                    ],
                ],
            ],
        ];
    }
}
