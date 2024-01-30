<?php

declare(strict_types=1);

namespace App\Application\Command;

class SortingGetterCommand
{
    public function __construct(
        public string $id
    ) {
    }
}
