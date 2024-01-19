<?php


namespace App\Application\Command\Sorting;


class SortingUrlGeneratorCommand
{
    public function __construct(
        public array $data,
        public string $originalUrl
    ) {
    }
}