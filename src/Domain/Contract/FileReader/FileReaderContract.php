<?php


namespace App\Domain\Contract\FileReader;


interface FileReaderContract
{
    public function handle(string $filePath): array;
}