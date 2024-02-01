<?php

namespace App\Tests\integration\Application\Service;

use App\Application\Command\SortingUrlGeneratorCommand;
use App\Application\Service\SortingUrlGenerator;
use App\Domain\Entity\Sorting;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SortingUrlGeneratorTest extends KernelTestCase
{
    private SortingUrlGenerator $sortingUrlGenerator;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $sortingRepository = $entityManager->getRepository(Sorting::class);
        $this->sortingUrlGenerator = new SortingUrlGenerator(
            $sortingRepository,
        );
    }

    public function testHandle()
    {
        $elements = [
            [
                'title' => 'test',
                'imageUrl' => 'test',
                'example' => 'test',
            ],
        ];

        $url = $this->sortingUrlGenerator->handle(
            new SortingUrlGeneratorCommand(
                $elements,
                'http://localhost/'
            )
        );

        $this->assertEquals('http://localhost/7c5a217f-6369-4eaa-bf6d-98daaf8e8dbc', $url);
    }
}
