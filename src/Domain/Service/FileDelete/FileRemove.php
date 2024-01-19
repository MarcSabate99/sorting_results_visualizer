<?php


namespace App\Domain\Service\FileDelete;


class FileRemove
{
    public function handle(string $filePath): void {
        if (!file_exists($filePath)) {
            return;
        }
        unlink($filePath);
    }
}