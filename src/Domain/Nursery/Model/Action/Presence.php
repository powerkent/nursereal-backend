<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model\Action;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Nursery\Model\Action;
use Ramsey\Uuid\UuidInterface;

class Presence extends Action
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
        protected ?DateTimeInterface $arrivalDateTime = null,
        protected ?DateTimeInterface $endDateTime = null,
        protected bool $isHere = false,
    ) {
        parent::__construct(
            uuid     : $uuid,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            children : $children,
            comment  : $comment,
        );
    }

    public function getArrivalDateTime(): ?DateTimeInterface
    {
        return $this->arrivalDateTime;
    }

    public function setArrivalDateTime(?DateTimeInterface $arrivalDateTime): self
    {
        $this->arrivalDateTime = $arrivalDateTime;

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

    public function isHere(): bool
    {
        return $this->isHere;
    }

    public function setIsHere(bool $isHere): self
    {
        $this->isHere = $isHere;

        return $this;
    }
}
