<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model\Action;

use DateTimeInterface;
use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Nursery\Model\Action;
use Ramsey\Uuid\UuidInterface;
use Nursery\Domain\Shared\Model\Treatment as WhatTreatment;

class Treatment extends Action
{
    public function __construct(
        UuidInterface $uuid,
        ActionState $state,
        DateTimeInterface $createdAt,
        ?DateTimeInterface $updatedAt,
        Child $child,
        Agent $agent,
        ?string $comment,
        protected WhatTreatment $treatment,
        protected ?string $dose,
        protected ?DateTimeInterface $dosingTime,
        protected ?float $temperature,
    ) {
        parent::__construct(
            uuid: $uuid,
            state: $state,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            child: $child,
            agent: $agent,
            comment: $comment,
        );

        $this->type = ActionType::Treatment;
    }

    public function getTreatment(): WhatTreatment
    {
        return $this->treatment;
    }

    public function getDose(): ?string
    {
        return $this->dose;
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
}
