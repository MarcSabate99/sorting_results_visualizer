<?php


namespace App\Domain\Service\FileReader;


use App\Domain\Contract\FileReader\FileReaderContract;
use App\Domain\Contract\Transformer\FileTransformerInterface;

class CsvFileReader implements FileReaderContract
{

    public function __construct(
        private FileTransformerInterface $fileTransformer
    )
    {
    }

    public function handle(string $filePath): array
    {
        $file = fopen($filePath, 'r');
        $data = [];

        if ($file === false) {
            return $data;
        }

        $keys = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            $transformedRow = array_combine($keys, $row);
            $data[] = $transformedRow;
        }

        fclose($file);
        return $this->fileTransformer->handle($data);
    }
}