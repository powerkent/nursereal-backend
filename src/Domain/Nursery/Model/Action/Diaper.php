<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model\Action;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Nursery\Enum\DiaperQuality;
use Nursery\Domain\Nursery\Model\Action;
use Ramsey\Uuid\UuidInterface;

class Diaper extends Action
{
    /**
     * @param array<int, Child>|Collection<int, Child> $children
     */
    public function __construct(
        UuidInterface $uuid,
        DateTimeInterface $createdAt,
        ?DateTimeInterface $updatedAt,
        Collection|array $children,
        ?string $comment,
        protected DiaperQuality $quality,
    ) {
        parent::__construct(
            uuid: $uuid,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            children: $children,
            comment: $comment,
        );
    }

    public function getQuality(): DiaperQuality
    {
        return $this->quality;
    }

    public function setQuality(DiaperQuality $quality): self
    {
        $this->quality = $quality;

        return $this;
    }
}
