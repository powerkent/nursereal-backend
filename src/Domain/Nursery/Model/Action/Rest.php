<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model\Action;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Nursery\Enum\RestQuality;
use Nursery\Domain\Nursery\Model\Action;
use Ramsey\Uuid\UuidInterface;

class Rest extends Action
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
        protected DateTimeInterface $startDateTime,
        protected ?DateTimeInterface $endDateTime = null,
        protected ?RestQuality $quality = null,
    ) {
        parent::__construct(
            uuid: $uuid,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            children: $children,
            comment: $comment,
        );
    }

    public function getStartDateTime(): DateTimeInterface
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(DateTimeInterface $startDateTime): self
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    public function getEndDateTime(): ?DateTimeInterface
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(?DateTimeInterface $endDateTime): self
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }

    public function getQuality(): ?RestQuality
    {
        return $this->quality;
    }

    public function setQuality(?RestQuality $quality): self
    {
        $this->quality = $quality;

        return $this;
    }
}
