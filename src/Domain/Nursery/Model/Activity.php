<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

class Activity
{
    protected ?int $id = null;

    public function __construct(
        protected UuidInterface $uuid,
        protected string $name,
        protected ?string $description,
        protected DateTimeInterface $createdAt,
        protected ?DateTimeInterface $updatedAt = null,
    ) {
        Assert::stringNotEmpty($this->name);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
