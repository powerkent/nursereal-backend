<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;

class Dosage
{
    protected ?int $id = null;

    public function __construct(
        protected ?Treatment $treatment,
        protected ?string $dose, // quantity
        protected ?DateTimeInterface $dosingTime,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTreatment(): ?Treatment
    {
        return $this->treatment;
    }

    public function setTreatment(?Treatment $treatment): self
    {
        $this->treatment = $treatment;

        return $this;
    }

    public function getDose(): ?string
    {
        return $this->dose;
    }

    public function setDose(?string $dose): self
    {
        $this->dose = $dose;

        return $this;
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
}
