<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model\Action;

use DateTimeInterface;
use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Nursery\Enum\DiaperQuality;
use Nursery\Domain\Nursery\Model\Action;
use Ramsey\Uuid\UuidInterface;

class Diaper extends Action
{
    public function __construct(
        UuidInterface $uuid,
        ActionState $state,
        DateTimeInterface $createdAt,
        ?DateTimeInterface $updatedAt,
        Child $child,
        Agent $agent,
        ?string $comment,
        protected DiaperQuality $quality,
    ) {
        parent::__construct(
            uuid: $uuid,
            state: $state,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            child: $child,
            agent: $agent,
            comment: $comment,
        );
        $this->type = ActionType::Diaper;
    }

    public function getQuality(): DiaperQuality
    {
        return $this->quality;
    }
}
