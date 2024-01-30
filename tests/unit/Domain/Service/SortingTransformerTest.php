<?php

namespace App\Tests\unit\Domain\Service;

use App\Domain\Service\SortingTransformer;
use App\Tests\stubs\ObjectMother\SortingMother;
use PHPUnit\Framework\TestCase;

class SortingTransformerTest extends TestCase
{
    private SortingTransformer $sortingTransformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sortingTransformer = new SortingTransformer();
    }

    /**
     * @dataProvider dataProviderTransformer
     */
    public function testTransform(array $elements)
    {
        foreach ($elements as $element) {
            $result = $this->sortingTransformer->transform($element['sorting']);
            $this->assertEquals($element['expected'], $result);
        }
    }

    public static function dataProviderTransformer(): array
    {
        return [
            'elements' => [
                [
                    [
                        'sorting' => SortingMother::create('{"example":"test"}', '58cc5974d418775b8cea27846876fefa'),
                        'expected' => [
                            'elements' => '{"example":"test"}',
                        ],
                    ],
                    [
                        'sorting' => SortingMother::create('{"example2":"test"}', '58cc5974d418775b8cea27846876fefa'),
                        'expected' => [
                            'elements' => '{"example2":"test"}',
                        ],
                    ],
                    [
                        'sorting' => null,
                        'expected' => [
                            'elements' => '[]',
                        ],
                    ],
                ],
            ],
        ];
    }
}
