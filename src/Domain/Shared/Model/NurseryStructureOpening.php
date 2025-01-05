<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Nursery\Domain\Shared\Enum\OpeningDays;

class NurseryStructureOpening
{
    protected ?int $id = null;

    public function __construct(
        protected DateTimeInterface $openingHour,
        protected DateTimeInterface $closingHour,
        protected OpeningDays $openingDay,
        protected ?NurseryStructure $nurseryStructure = null,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOpeningHour(): DateTimeInterface
    {
        return $this->openingHour;
    }

    public function getClosingHour(): DateTimeInterface
    {
        return $this->closingHour;
    }

    public function getOpeningDay(): OpeningDays
    {
        return $this->openingDay;
    }

    public function setNurseryStructure(?NurseryStructure $nurseryStructure): self
    {
        $this->nurseryStructure = $nurseryStructure;

        return $this;
    }
}
