<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model\Action;

use DateTimeInterface;
use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Nursery\Model\CompletedActionInterface;
use Nursery\Domain\Nursery\Model\CompletedActionTrait;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Nursery\Model\Action;
use Ramsey\Uuid\UuidInterface;

class Presence extends Action implements CompletedActionInterface
{
    use CompletedActionTrait;

    public function __construct(
        UuidInterface $uuid,
        ActionState $state,
        DateTimeInterface $createdAt,
        ?DateTimeInterface $updatedAt,
        Child $child,
        Agent $agent,
        ?string $comment,
        protected bool $isAbsent = true,
    ) {
        parent::__construct(
            uuid     : $uuid,
            state    : $state,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            child    : $child,
            agent    : $agent,
            comment  : $comment,
        );

        $this->type = ActionType::Presence;
    }

    public function isAbsent(): bool
    {
        return $this->isAbsent;
    }

    public function setIsAbsent(bool $isAbsent): self
    {
        $this->isAbsent = $isAbsent;

        return $this;
    }
}
