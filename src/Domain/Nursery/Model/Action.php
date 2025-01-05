<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model;

use DateTimeInterface;
use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\Child;
use Ramsey\Uuid\UuidInterface;

class Action
{
    protected ActionType $type;

    protected ?int $id = null;

    public function __construct(
        protected UuidInterface $uuid,
        protected ActionState $state,
        protected DateTimeInterface $createdAt,
        protected ?DateTimeInterface $updatedAt,
        protected Child $child,
        protected Agent $agent,
        protected ?string $comment = null,
    ) {
        $this->type = ActionType::Action;
    }

    public function getType(): ActionType
    {
        return $this->type;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getState(): ActionState
    {
        return $this->state;
    }

    public function setState(ActionState $state): self
    {
        $this->state = $state;

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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getChild(): Child
    {
        return $this->child;
    }

    public function getAgent(): Agent
    {
        return $this->agent;
    }
}
