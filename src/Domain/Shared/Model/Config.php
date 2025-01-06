<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use Ramsey\Uuid\UuidInterface;

class Config
{
    protected ?int $id = null;

    public const string AGENT_LOGIN_WITH_PHONE = 'AGENT_LOGIN_WITH_PHONE';

    public function __construct(
        protected UuidInterface $uuid,
        protected string $name,
        protected bool $value
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getValue(): bool
    {
        return $this->value;
    }

    public function setValue(bool $value): self
    {
        $this->value = $value;

        return $this;
    }
}
