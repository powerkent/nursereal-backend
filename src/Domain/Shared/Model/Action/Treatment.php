<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model\Action;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Enum\ActionType;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Nursery\Model\Action\Treatment as WhatTreatment;
use Nursery\Domain\Nursery\Model\Child;
use Ramsey\Uuid\UuidInterface;

class Treatment extends Action
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
        protected WhatTreatment $treatment,
        protected ?float $temperature,
    ) {
        parent::__construct(
            uuid: $uuid,
            createdAt: $createdAt,
            children: $children,
            comment: $comment,
        );

        $this->type = ActionType::Treatment;
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

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }
}
