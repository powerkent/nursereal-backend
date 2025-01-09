<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

class AgentSchedule
{
    protected ?int $id = null;

    public function __construct(
        protected UuidInterface $uuid,
        protected Agent $agent,
        protected DateTimeInterface $arrivalDateTime,
        protected DateTimeInterface $endOfWorkDateTime,
        protected DateTimeInterface $breakDateTime,
        protected DateTimeInterface $endOfBreakDateTime,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getAgent(): Agent
    {
        return $this->agent;
    }

    public function setAgent(Agent $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    public function getEndOfWorkDateTime(): DateTimeInterface
    {
        return $this->endOfWorkDateTime;
    }

    public function setEndOfWorkDateTime(DateTimeInterface $endOfWorkDateTime): self
    {
        $this->endOfWorkDateTime = $endOfWorkDateTime;

        return $this;
    }

    public function getBreakDateTime(): DateTimeInterface
    {
        return $this->breakDateTime;
    }

    public function setBreakDateTime(DateTimeInterface $breakDateTime): self
    {
        $this->breakDateTime = $breakDateTime;

        return $this;
    }

    public function getArrivalDateTime(): DateTimeInterface
    {
        return $this->arrivalDateTime;
    }

    public function setArrivalDateTime(DateTimeInterface $arrivalDateTime): self
    {
        $this->arrivalDateTime = $arrivalDateTime;

        return $this;
    }

    public function getEndOfBreakDateTime(): DateTimeInterface
    {
        return $this->endOfBreakDateTime;
    }

    public function setEndOfBreakDateTime(DateTimeInterface $endOfBreakDateTime): self
    {
        $this->endOfBreakDateTime = $endOfBreakDateTime;

        return $this;
    }
}
