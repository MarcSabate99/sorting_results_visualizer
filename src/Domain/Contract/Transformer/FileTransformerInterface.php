<?php


namespace App\Domain\Contract\Transformer;


interface FileTransformerInterface
{
    public function handle(array $data): array;
}