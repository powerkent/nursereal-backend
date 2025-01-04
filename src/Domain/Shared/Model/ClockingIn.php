<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Nursery\Domain\Shared\Enum\ClockingInState;
use Ramsey\Uuid\UuidInterface;

class ClockingIn
{
    protected ?int $id = null;

    public function __construct(
        protected UuidInterface $uuid,
        protected ClockingInState $state,
        protected Agent $agent,
        protected NurseryStructure $nurseryStructure,
        protected DateTimeInterface $startDateTime,
        protected ?DateTimeInterface $endDateTime,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function setUuid(UuidInterface $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getState(): ClockingInState
    {
        return $this->state;
    }

    public function setState(ClockingInState $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getAgent(): Agent
    {
        return $this->agent;
    }

    public function setAgent(Agent $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    public function getNurseryStructure(): NurseryStructure
    {
        return $this->nurseryStructure;
    }

    public function setNurseryStructure(NurseryStructure $nurseryStructure): self
    {
        $this->nurseryStructure = $nurseryStructure;

        return $this;
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
}
