<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Command\SortingGetterCommand;
use App\Domain\Interface\SortingRepositoryInterface;
use App\Domain\Service\SortingTransformer;

readonly class SortingGetter
{
    public function __construct(
        private SortingRepositoryInterface $sortingRepository,
        private SortingTransformer $sortingTransformer
    ) {
    }

    public function handle(
        SortingGetterCommand $command
    ): array {
        $elements = $this->sortingRepository->getById($command->id);

        return $this->sortingTransformer->transform($elements);
    }
}
