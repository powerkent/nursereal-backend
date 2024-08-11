<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model\Action;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Shared\Enum\ActionType;
use Nursery\Domain\Shared\Model\Action;
use Nursery\Domain\Shared\Model\Activity as WhatActivity;
use Ramsey\Uuid\UuidInterface;

class Activity extends Action
{
    protected ActionType $type;

    /**
     * @param array<int, Child>|Collection<int, Child> $children
     */
    public function __construct(
        UuidInterface $uuid,
        DateTimeInterface $createdAt,
        Collection|array $children,
        ?string $comment,
        protected WhatActivity $activity,
    ) {
        parent::__construct(
            uuid     : $uuid,
            createdAt: $createdAt,
            children : $children,
            comment  : $comment,
        );

        $this->type = ActionType::Activity;
    }

    public function getActivity(): WhatActivity
    {
        return $this->activity;
    }

    public function setActivity(WhatActivity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }
}
