<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model\Action;

use DateTimeInterface;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Nursery\Model\AbstractAction;
use Ramsey\Uuid\UuidInterface;
use Nursery\Domain\Shared\Model\Treatment as WhatTreatment;
use Doctrine\Common\Collections\Collection;

class Treatment extends AbstractAction
{
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
