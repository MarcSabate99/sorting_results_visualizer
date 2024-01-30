<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Sorting;

readonly class SortingTransformer
{
    public function transform(?Sorting $sorting): array
    {
        if (null === $sorting) {
            return [
                'elements' => json_encode([]),
            ];
        }

        return [
            'elements' => $sorting->getData(),
        ];
    }
}
