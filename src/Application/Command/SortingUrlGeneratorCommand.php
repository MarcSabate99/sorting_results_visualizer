<?php


namespace App\Application\Command;


class SortingUrlGeneratorCommand
{
    public function __construct(
        public array $elements,
        public string $originalUrl
    ) {
    }
}