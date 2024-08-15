<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model\Action;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Shared\Enum\RestQuality;
use Nursery\Domain\Shared\Model\AbstractAction;
use Ramsey\Uuid\UuidInterface;

class Rest extends AbstractAction
{
    /**
     * @param array<int, Child>|Collection<int, Child> $children
     */
    public function __construct(
        UuidInterface $uuid,
        DateTimeInterface $createdAt,
        Collection|array $children,
        ?string $comment,
        protected DateTimeInterface $restEndDate,
        protected RestQuality $restQuality,
    ) {
        parent::__construct(
            uuid: $uuid,
            createdAt: $createdAt,
            children: $children,
            comment: $comment,
        );
    }

    public function getRestEndDate(): DateTimeInterface
    {
        return $this->restEndDate;
    }

    public function setRestEndDate(DateTimeInterface $restEndDate): self
    {
        $this->restEndDate = $restEndDate;

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
