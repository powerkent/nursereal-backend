<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model;

use DateTimeInterface;
use Nursery\Domain\Shared\Model\Agent;

interface CompletedActionInterface
{
    public function getStartDateTime(): ?DateTimeInterface;

    public function setStartDateTime(?DateTimeInterface $dateTime): self;

    public function getEndDateTime(): ?DateTimeInterface;

    public function setEndDateTime(?DateTimeInterface $dateTime): self;

    public function getCompletedAgent(): ?Agent;

    public function setCompletedAgent(?Agent $agent): self;
}
