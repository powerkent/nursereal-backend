<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Webmozart\Assert\Assert;

class IRP
{
    protected ?int $id = null;

    public function __construct(
        protected string $name,
        protected string $description,
        protected DateTimeInterface $createdAt,
        protected DateTimeInterface $startAt,
        protected ?DateTimeInterface $endAt = null,
    ) {
        Assert::stringNotEmpty($this->name);
        Assert::stringNotEmpty($this->description);
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
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

    public function getStartAt(): DateTimeInterface
    {
        return $this->startAt;
    }

    public function getEndAt(): ?DateTimeInterface
    {
        return $this->endAt;
    }
}
