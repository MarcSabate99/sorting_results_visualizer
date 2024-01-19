<?php


namespace App\Application\Service\Sorting;


use App\Application\Command\Sorting\SortingUrlGeneratorCommand;

class SortingUrlGenerator
{
    private const QUERY_PARAM = '?data=';

    public function handle(
        SortingUrlGeneratorCommand $command
    ): string {
        $minified_json = json_encode($command->data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $url_encoded_data = urlencode($minified_json);
        return $command->originalUrl . self::QUERY_PARAM . $url_encoded_data;
    }
}