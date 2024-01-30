<?php

namespace App\Tests\unit\Application\Service;

use App\Application\Command\SortingUrlGeneratorCommand;
use App\Application\Service\SortingUrlGenerator;
use App\Domain\Entity\Sorting;
use App\Domain\Interface\SortingRepositoryInterface;
use App\Domain\Service\DataValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class SortingUrlGeneratorTest extends TestCase
{
    private SortingUrlGenerator $sortingUrlGenerator;
    private SortingRepositoryInterface $sortingRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sortingRepository = $this->createMock(SortingRepositoryInterface::class);
        $dataValidator = new DataValidator();

        $this->sortingUrlGenerator = new SortingUrlGenerator(
            $this->sortingRepository,
            $dataValidator
        );
    }

    public function testHandleWithEmptyElements()
    {
        $elements = [];

        $sortingUrl = $this->sortingUrlGenerator->handle(
            new SortingUrlGeneratorCommand(
                $elements,
                'http://localhost/'
            )
        );

        $this->assertEquals('http://localhost/', $sortingUrl);
    }

    public function testHandleWithNonEmptyElements()
    {
        $elements = [
            [
                'title' => 'test',
                'imageUrl' => 'test',
                'example' => 'test',
            ],
        ];
        $sortingCommand = new SortingUrlGeneratorCommand(
            $elements,
            'http://localhost/'
        );
        $existentSorting = new Sorting();
        $specificId = Uuid::v4();

        $existentSorting->setId($specificId);
        $this->sortingRepository->expects($this->once())
            ->method('getByHash')
            ->willReturn($existentSorting);

        $sortingUrl = $this->sortingUrlGenerator->handle(
            $sortingCommand
        );
        $this->assertEquals('http://localhost/'.$specificId, $sortingUrl);
    }
}
