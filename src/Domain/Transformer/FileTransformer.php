<?php


namespace App\Domain\Transformer;


use App\Domain\Contract\Transformer\FileTransformerInterface;

class FileTransformer implements FileTransformerInterface
{

    public function handle(array $data): array
    {
        $transformedData = [];
        foreach ($data as $key => $element) {
            if (array_key_exists('title', $element)) {
                $transformedData[$key]['title'] = $element['title'];
            } else {
                $firstElement = reset($element);
                $transformedData[$key]['title'] = $firstElement;
            }
            $transformedData[$key]['imageUrl'] = array_key_exists('imageUrl', $element) ? $element['imageUrl'] : null;
            $otherKeys = array_diff_key($element, array_flip(['title', 'imageUrl', 'highlighted']));
            $transformedData[$key]['others'] = $otherKeys;

            if (array_key_exists('highlighted', $element)) {
                $transformedData[$key]['highlighted'] = trim($element['highlighted']);
            }
        }
        return $transformedData;
    }
}