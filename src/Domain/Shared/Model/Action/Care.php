<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model\Action;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Enum\ActionType;
use Enum\CareType;
use Enum\DiaperQuality;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Nursery\Model\Child;
use Ramsey\Uuid\UuidInterface;

class Care extends Action
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
        protected ?CareType $careType = null,
        protected ?DiaperQuality $quality = null,
    ) {
        parent::__construct(
            uuid: $uuid,
            createdAt: $createdAt,
            children: $children,
            comment: $comment,
        );

        $this->type = ActionType::Care;
    }

    public function getCareType(): ?CareType
    {
        return $this->careType;
    }

    public function setCareType(?CareType $careType): self
    {
        $this->careType = $careType;

        return $this;
    }

    public function getQuality(): ?DiaperQuality
    {
        return $this->quality;
    }

    public function setQuality(?DiaperQuality $quality): self
    {
        $this->quality = $quality;

        return $this;
    }
}
