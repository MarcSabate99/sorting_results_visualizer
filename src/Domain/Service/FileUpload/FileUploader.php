<?php


namespace App\Domain\Service\FileUpload;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private const UPLOAD_DIRECTORY = 'data';

    public function handle(UploadedFile $uploadedFile): string {
        $randomFileName = uniqid() . '_' . time() . '.' . $uploadedFile->getClientOriginalExtension();
        $uploadedFilePath = self::UPLOAD_DIRECTORY . '/' . $randomFileName;
        $uploadedFile->move(self::UPLOAD_DIRECTORY, $randomFileName);
        return $uploadedFilePath;
    }

}