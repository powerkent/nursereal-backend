<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model\Action;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Shared\Enum\ActionType;
use Nursery\Domain\Shared\Enum\RestQuality;
use Nursery\Domain\Shared\Model\Action;
use Ramsey\Uuid\UuidInterface;

class Rest extends Action
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
        protected DateTimeInterface $endDate,
        protected RestQuality $restQuality,
    ) {
        parent::__construct(
            uuid: $uuid,
            createdAt: $createdAt,
            children: $children,
            comment: $comment,
        );

        $this->type = ActionType::Rest;
    }

    public function getEndDate(): DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getRestQuality(): RestQuality
    {
        return $this->restQuality;
    }

    public function setRestQuality(RestQuality $restQuality): self
    {
        $this->restQuality = $restQuality;

        return $this;
    }
}
