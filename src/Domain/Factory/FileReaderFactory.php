<?php


namespace App\Domain\Factory;

use App\Domain\Contract\FileReader\FileReaderContract;
use App\Domain\Exception\InvalidFileException;
use App\Domain\Service\FileReader\CsvFileReader;
use App\Domain\Service\FileReader\JsonFileReader;
use App\Domain\Transformer\FileTransformer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileReaderFactory
{

    public function __construct(
        private FileTransformer $fileTransformer,
    )
    {
    }

    public function make(UploadedFile $uploadedFile): FileReaderContract
    {
        $extension = $uploadedFile->getClientOriginalExtension();
        return match (strtolower($extension)) {
            'json' => new JsonFileReader(
                $this->fileTransformer
            ),
            'csv' => new CsvFileReader(
                $this->fileTransformer
            ),
            default => throw InvalidFileException::ofExtension($extension),
        };
    }
}