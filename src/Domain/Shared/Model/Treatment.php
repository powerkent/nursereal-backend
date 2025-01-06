<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

class Treatment
{
    protected ?int $id = null;

    /** @var Collection<int, Dosage> */
    protected Collection $dosages;

    /**
     * @param array<int, Dosage>|Collection<int, Dosage> $dosages
     */
    public function __construct(
        protected UuidInterface $uuid,
        protected ?Child $child,
        protected string $name,
        protected string $description,
        protected DateTimeInterface $createdAt,
        protected DateTimeInterface $startAt,
        protected ?DateTimeInterface $endAt = null,
        array|Collection $dosages = [],
    ) {
        Assert::stringNotEmpty($this->name);
        Assert::stringNotEmpty($this->description);

        $this->dosages = !is_array($dosages) ? $dosages : new ArrayCollection($dosages);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getChild(): ?Child
    {
        return $this->child;
    }

    public function setChild(?Child $child): self
    {
        $this->child = $child;

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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStartAt(): DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * @return Collection<int, Dosage>
     */
    public function getDosages(): Collection
    {
        return $this->dosages;
    }

    public function addDosage(Dosage $dosage): self
    {
        if (!$this->dosages->contains($dosage)) {
            $this->dosages->add($dosage);
            $dosage->setTreatment($this);
        }

        return $this;
    }
}
