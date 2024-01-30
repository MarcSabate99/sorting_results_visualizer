<?php

namespace App\Tests\unit\Application\Service;

use App\Application\Command\SortingGetterCommand;
use App\Application\Service\SortingGetter;
use App\Domain\Interface\SortingRepositoryInterface;
use App\Domain\Service\SortingTransformer;
use App\Tests\stubs\ObjectMother\SortingMother;
use PHPUnit\Framework\TestCase;

class SortingGetterTest extends TestCase
{
    private SortingGetter $sortingGetter;
    private SortingRepositoryInterface $sortingRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sortingRepository = $this->createMock(SortingRepositoryInterface::class);
        $sortingTransformer = new SortingTransformer();

        $this->sortingGetter = new SortingGetter(
            $this->sortingRepository,
            $sortingTransformer
        );
    }

    public function testHandleWithExistentSorting()
    {
        $id = '018d5195-8008-7ba7-94b8-9b3c690bd449';
        $this->sortingRepository->expects($this->once())
            ->method('getById')
            ->with($id)
            ->willReturn(SortingMother::create('{"example":"test"}', '58cc5974d418775b8cea27846876fefa'));

        $sortingData = $this->sortingGetter->handle(
            new SortingGetterCommand(
                $id
            )
        );
        $this->assertEquals(['elements' => '{"example":"test"}'], $sortingData);
    }

    public function testHandleWithoutExistentSorting()
    {
        $id = '018d5195-8008-7ba7-94b8-9b3c690bd449';
        $this->sortingRepository->expects($this->once())
            ->method('getById')
            ->with($id)
            ->willReturn(null);

        $sortingData = $this->sortingGetter->handle(
            new SortingGetterCommand(
                $id
            )
        );
        $this->assertEquals(['elements' => '[]'], $sortingData);
    }

    public function testHandleWithoutId()
    {
        $id = '';
        $this->sortingRepository->expects($this->once())
            ->method('getById')
            ->with($id)
            ->willReturn(null);

        $sortingData = $this->sortingGetter->handle(
            new SortingGetterCommand(
                $id
            )
        );
        $this->assertEquals(['elements' => '[]'], $sortingData);
    }
}
