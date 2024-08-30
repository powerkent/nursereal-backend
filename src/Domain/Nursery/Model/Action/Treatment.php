<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model\Action;

use DateTimeInterface;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Nursery\Model\Action;
use Ramsey\Uuid\UuidInterface;
use Nursery\Domain\Shared\Model\Treatment as WhatTreatment;
use Doctrine\Common\Collections\Collection;

class Treatment extends Action
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
        protected WhatTreatment $treatment,
        protected ?string $dose,
        protected ?DateTimeInterface $dosingTime,
        protected ?float $temperature,
    ) {
        parent::__construct(
            uuid: $uuid,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            children: $children,
            comment: $comment,
        );
    }

    public function getTreatment(): WhatTreatment
    {
        return $this->treatment;
    }

    public function setTreatment(WhatTreatment $treatment): self
    {
        $this->treatment = $treatment;

        return $this;
    }

    public function getDose(): ?string
    {
        return $this->dose;
    }

    public function setDose(?string $dose): void
    {
        $this->dose = $dose;
    }

    public function getDosingTime(): ?DateTimeInterface
    {
        return $this->dosingTime;
    }

    public function setDosingTime(?DateTimeInterface $dosingTime): self
    {
        $this->dosingTime = $dosingTime;

        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(?float $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }
}
