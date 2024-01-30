<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Infrastructure\Exception\RequestBodyValidationException;
use Symfony\Component\HttpFoundation\Request;

class RequestValidation
{
    public function validateInternalFields(Request $request, array $requiredFields): void
    {
        $content = json_decode($request->getContent(), true) ?? [];
        foreach ($requiredFields as $field) {
            if (!isset($content[$field])) {
                throw RequestBodyValidationException::ofRequiredParam($field);
            }
        }
    }
}
