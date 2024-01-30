<?php

namespace App\Tests\integration\Infrastructure\Repository;

use App\Domain\Entity\Sorting;
use App\Infrastructure\Repository\SortingRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SortingRepositoryTest extends KernelTestCase
{
    private SortingRepository $sortingRepository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->sortingRepository = $entityManager->getRepository(Sorting::class);
    }

    public function testSaveAndGetById(): void
    {
        $sorting = new Sorting();
        $sorting->setData('Test Data');
        $sorting->setDataHash(md5('Test Data'));
        $this->sortingRepository->save($sorting);
        $id = $sorting->getId();
        $retrievedSorting = $this->sortingRepository->getById($id);
        $this->assertEquals($sorting, $retrievedSorting);
    }

    public function testGetByHash(): void
    {
        $sorting = new Sorting();
        $sorting->setData('Test Data');
        $sorting->setDataHash(md5('Test Data'));
        $this->sortingRepository->save($sorting);
        $hashedData = $sorting->getDataHash();
        $retrievedSorting = $this->sortingRepository->getByHash($hashedData);
        $this->assertEquals($sorting->getDataHash(), $retrievedSorting->getDataHash());
    }
}
