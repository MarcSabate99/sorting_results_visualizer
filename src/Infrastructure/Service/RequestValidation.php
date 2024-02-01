<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Infrastructure\Exception\RequestBodyValidationException;
use Symfony\Component\HttpFoundation\Request;

class RequestValidation
{
    public function validateInternalFields(Request $request, array $requiredFields, array $internalFields): void
    {
        $content = json_decode($request->getContent(), true) ?? [];

        foreach ($requiredFields as $field) {
            $this->validateRequiredField($content, $field);

            foreach ($internalFields as $internalField) {
                $this->validateInternalField($content[$field], $internalField);
            }
        }
    }

    private function validateRequiredField(array $content, string $field): void
    {
        if (!isset($content[$field])) {
            throw RequestBodyValidationException::ofRequiredParam($field);
        }
    }

    private function validateInternalField(array $internalData, string $internalField): void
    {
        foreach ($internalData as $data) {
            if (empty($data[$internalField])) {
                throw RequestBodyValidationException::ofRequiredParam($internalField);
            }
        }
    }

}
