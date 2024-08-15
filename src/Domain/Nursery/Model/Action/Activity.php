<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model\Action;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Nursery\Model\AbstractAction;
use Nursery\Domain\Nursery\Model\Activity as WhatActivity;
use Ramsey\Uuid\UuidInterface;

class Activity extends AbstractAction
{
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
