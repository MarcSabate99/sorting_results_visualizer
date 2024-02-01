<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Command\SortingUrlGeneratorCommand;
use App\Domain\Entity\Sorting;
use App\Domain\Interface\SortingRepositoryInterface;

readonly class SortingUrlGenerator
{
    public function __construct(
        private SortingRepositoryInterface $sortingRepository
    ) {
    }

    public function handle(
        SortingUrlGeneratorCommand $command
    ): string {
        if (empty($command->elements)) {
            return $command->originalUrl;
        }

        $data = json_encode($command->elements);
        $sorting = (new Sorting())
            ->setData($data)
            ->setDataHash(md5($data));

        $existentSorting = $this->sortingRepository->getByHash($sorting->getDataHash());
        $id = $existentSorting?->getId();

        if (null === $existentSorting) {
            $this->sortingRepository->save($sorting);
            $id = $sorting->getId();
        }

        return $command->originalUrl.$id;
    }
}
