<?php

namespace App\Application\Command;

class SortingGetterCommand
{
    public function __construct(
        public string $id
    ) {
    }
}