<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\SortingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SortingRepository::class)]
class Sorting
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid  $id = null;

    #[ORM\Column(length: 1000000)]
    private ?string $data = null;

    #[ORM\Column]
    private ?string $dataHash = null;

    public function getId(): ?Uuid
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
}
