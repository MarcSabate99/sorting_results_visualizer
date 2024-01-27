<?php

namespace App\Domain\Service;

use App\Domain\Exception\DataValidationException;

readonly class DataValidator
{
    private const REQUIRED_FIELDS = ['title', 'imageUrl'];
    public function handle(array $elements)
    {
        foreach ($elements as $element) {
            foreach (self::REQUIRED_FIELDS as $field) {
                if(!isset($element[$field])) {
                    throw DataValidationException::ofRequiredField($field);
                }
            }
        }
    }
}