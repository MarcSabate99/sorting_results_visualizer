<?php

namespace App\Tests\stubs\ObjectMother;

use App\Domain\Entity\Sorting;

class SortingMother
{
    public static function create(
        string $data,
        string $dataHash
    ): Sorting {
        return (new Sorting())
            ->setData($data)
            ->setDataHash($dataHash);
    }
}
