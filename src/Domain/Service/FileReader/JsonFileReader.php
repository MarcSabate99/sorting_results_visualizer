<?php


namespace App\Domain\Service\FileReader;

use App\Domain\Contract\FileReader\FileReaderContract;
use App\Domain\Contract\Transformer\FileTransformerInterface;

class JsonFileReader implements FileReaderContract
{
    public function __construct(
        private FileTransformerInterface $fileTransformer
    )
    {
    }

    public function handle(string $filePath): array
    {
        return [];
    }
}