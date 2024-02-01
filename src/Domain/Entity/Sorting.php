<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class Sorting
{
    private ?string  $id = null;

    private ?string $data = null;

    private ?string $dataHash = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getDataHash(): ?string
    {
        return $this->dataHash;
    }

    public function setDataHash(?string $dataHash): self
    {
        $this->dataHash = $dataHash;

        return $this;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }
}
