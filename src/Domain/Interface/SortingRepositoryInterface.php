<?php

namespace App\Domain\Interface;

use App\Domain\Entity\Sorting;

interface SortingRepositoryInterface
{
    public function save(Sorting $sorting): void;

    public function getById(string $id): ?Sorting;

    public function getByHash(string $hashedData): ?Sorting;
}