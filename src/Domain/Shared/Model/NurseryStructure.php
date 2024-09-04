<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

class NurseryStructure
{
    protected ?int $id = null;

    public function __construct(
        protected UuidInterface $uuid,
        protected string $name,
        protected string $address,
        protected DateTimeInterface $createdAt,
        protected ?DateTimeInterface $updatedAt = null,
        protected ?DateTimeInterface $startAt = null,
        protected ?DateTimeInterface $endAt = null,
    ) {
        Assert::stringNotEmpty($this->name);
        Assert::stringNotEmpty($this->address);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function setUuid(UuidInterface $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
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

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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

    public function getStartAt(): ?DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(?DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }
}
