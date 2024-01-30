<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Command\SortingUrlGeneratorCommand;
use App\Domain\Entity\Sorting;
use App\Domain\Interface\SortingRepositoryInterface;
use App\Domain\Service\DataValidator;

readonly class SortingUrlGenerator
{
    public function __construct(
        private SortingRepositoryInterface $sortingRepository,
        private DataValidator $dataValidator
    ) {
    }

    public function handle(
        SortingUrlGeneratorCommand $command
    ): string {
        if (empty($command->elements)) {
            return $command->originalUrl;
        }

        $this->dataValidator->handle($command->elements);
        $data = json_encode($command->elements);
        $sorting = (new Sorting())
            ->setData($data)
            ->setDataHash(md5($data));

        $existentSorting = $this->sortingRepository->getByHash($sorting->getDataHash());
        $id = $existentSorting?->getId()?->toRfc4122();

        if (null === $existentSorting) {
            $this->sortingRepository->save($sorting);
            $id = $sorting->getId()->toRfc4122();
        }

        return $command->originalUrl.$id;
    }
}
