<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model\Action;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Shared\Enum\DiaperQuality;
use Nursery\Domain\Shared\Model\AbstractAction;
use Ramsey\Uuid\UuidInterface;

class Diaper extends AbstractAction
{
    /**
     * @param array<int, Child>|Collection<int, Child> $children
     */
    public function __construct(
        UuidInterface $uuid,
        DateTimeInterface $createdAt,
        Collection|array $children,
        ?string $comment,
        protected DiaperQuality $diaperQuality,
    ) {
        parent::__construct(
            uuid: $uuid,
            createdAt: $createdAt,
            children: $children,
            comment: $comment,
        );
    }

    public function getDiaperQuality(): DiaperQuality
    {
        return $this->diaperQuality;
    }

    public function setDiaperQuality(DiaperQuality $diaperQuality): self
    {
        $this->diaperQuality = $diaperQuality;

        return $this;
    }
}
