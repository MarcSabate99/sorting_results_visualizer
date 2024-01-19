<?php

namespace App\Application\Service\Sorting;

use App\Application\Command\Sorting\SortingVisualizerCommand;
use App\Domain\Factory\FileReaderFactory;
use App\Domain\Service\FileDelete\FileRemove;
use App\Domain\Service\FileUpload\FileUploader;

class SortingVisualizer
{

    public function __construct(
        private FileReaderFactory $fileReaderFactory,
        private FileUploader $fileUploader,
        private FileRemove $fileRemove
    )
    {
    }

    public function handle(
        SortingVisualizerCommand $sortingVisualizerCommand
    ): array {
        $filePath = $this->fileUploader->handle($sortingVisualizerCommand->uploadedFile);
        $reader = $this->fileReaderFactory->make($sortingVisualizerCommand->uploadedFile);
        $transformedData = $reader->handle($filePath);
        $this->fileRemove->handle($filePath);
        return $transformedData;
    }
}