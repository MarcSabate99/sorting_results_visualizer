<?php

declare(strict_types=1);

namespace App\Application\Command;

class SortingUrlGeneratorCommand
{
    public function __construct(
        public array $elements,
        public string $originalUrl
    ) {
    }
}
