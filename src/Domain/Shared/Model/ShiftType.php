<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;
use function is_array;

class ShiftType
{
    protected ?int $id = null;

    /** @var Collection<int, NurseryStructure> */
    protected Collection $nurseryStructures;

    /**
     * @param array<int, NurseryStructure>|Collection<int, NurseryStructure> $nurseryStructures
     */
    public function __construct(
        protected UuidInterface $uuid,
        protected string $name,
        protected DateTimeInterface $arrivalTime,
        protected DateTimeInterface $endOfWorkTime,
        protected DateTimeInterface $breakTime,
        protected DateTimeInterface $endOfBreakTime,
        array|Collection $nurseryStructures = [],
    ) {
        Assert::stringNotEmpty($this->name);

        $this->nurseryStructures = is_array($nurseryStructures) ? new ArrayCollection($nurseryStructures) : $nurseryStructures;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEndOfWorkTime(): DateTimeInterface
    {
        return $this->endOfWorkTime;
    }

    public function setEndOfWorkTime(DateTimeInterface $endOfWorkTime): self
    {
        $this->endOfWorkTime = $endOfWorkTime;

        return $this;
    }

    public function getArrivalTime(): DateTimeInterface
    {
        return $this->arrivalTime;
    }

    public function setArrivalTime(DateTimeInterface $arrivalTime): self
    {
        $this->arrivalTime = $arrivalTime;

        return $this;
    }

    public function getBreakTime(): DateTimeInterface
    {
        return $this->breakTime;
    }

    public function setBreakTime(DateTimeInterface $breakTime): self
    {
        $this->breakTime = $breakTime;

        return $this;
    }

    public function getEndOfBreakTime(): DateTimeInterface
    {
        return $this->endOfBreakTime;
    }

    public function setEndOfBreakTime(DateTimeInterface $endOfBreakTime): self
    {
        $this->endOfBreakTime = $endOfBreakTime;

        return $this;
    }

    /**
     * @return Collection<int, NurseryStructure>
     */
    public function getNurseryStructures(): Collection
    {
        return $this->nurseryStructures;
    }

    /**
     * @param Collection<int, NurseryStructure> $nurseryStructures
     */
    public function setNurseryStructures(Collection $nurseryStructures): self
    {
        $this->nurseryStructures = $nurseryStructures;

        return $this;
    }
}
