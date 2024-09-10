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

    public function setOpeningHour(DateTimeInterface $openingHour): self
    {
        $this->openingHour = $openingHour;

        return $this;
    }

    public function getClosingHour(): DateTimeInterface
    {
        return $this->closingHour;
    }

    public function setClosingHour(DateTimeInterface $closingHour): self
    {
        $this->closingHour = $closingHour;

        return $this;
    }

    public function getOpeningDay(): OpeningDays
    {
        return $this->openingDay;
    }

    public function setOpeningDays(OpeningDays $openingDay): self
    {
        $this->openingDay = $openingDay;

        return $this;
    }

    public function getNurseryStructure(): ?NurseryStructure
    {
        return $this->nurseryStructure;
    }

    public function setNurseryStructure(?NurseryStructure $nurseryStructure): self
    {
        $this->nurseryStructure = $nurseryStructure;

        return $this;
    }
}
