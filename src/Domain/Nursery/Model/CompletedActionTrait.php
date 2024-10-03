<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model;

use DateTimeInterface;
use Nursery\Domain\Shared\Model\Agent;

trait CompletedActionTrait
{
    protected DateTimeInterface $startDateTime;
    protected ?DateTimeInterface $endDateTime = null;
    protected ?Agent $completedAgent = null;

    public function getStartDateTime(): DateTimeInterface
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(DateTimeInterface $dateTime): self
    {
        $this->startDateTime = $dateTime;

        return $this;
    }

    public function getEndDateTime(): ?DateTimeInterface
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(?DateTimeInterface $dateTime): self
    {
        $this->endDateTime = $dateTime;

        return $this;
    }

    public function getCompletedAgent(): ?Agent
    {
        return $this->completedAgent;
    }

    public function setCompletedAgent(?Agent $agent): self
    {
        $this->completedAgent = $agent;

        return $this;
    }
}
