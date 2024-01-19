<?php


namespace App\Application\Command\Sorting;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class SortingVisualizerCommand
{
    public function __construct(
        public UploadedFile $uploadedFile
    )
    {
    }
}