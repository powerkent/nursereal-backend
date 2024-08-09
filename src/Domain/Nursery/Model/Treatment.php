<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model;

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

    public function setUuid(UuidInterface $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
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

    public function getDosages(): ?Collection
    {
        return $this->dosages;
    }

    /**
     * @param array<int, Dosage>|Collection<int, Dosage>|null $dosages
     */
    public function setDosages(Collection|array $dosages): self
    {
        $this->dosages = $dosages instanceof Collection ? $dosages : new ArrayCollection($dosages);

        return $this;
    }

    public function addDosage(Dosage $dosage): self
    {
        if (!$this->dosages->contains($dosage)) {
            $this->dosages->add($dosage);
            $dosage->setTreatment($this);
        }

        return $this;
    }

    public function removeDosage(Dosage $dosage): self
    {
        if ($this->dosages->contains($dosage)) {
            $this->dosages->removeElement($dosage);
            $dosage->setTreatment(null);
        }

        return $this;
    }

    public function sortDosagesById(): Collection
    {
        $sortedDosages = $this->dosages->getValues();
        usort($sortedDosages, function (Treatment $a, Treatment $b) {
            return $a->getId() > $b->getId();
        });

        return new ArrayCollection($sortedDosages);
    }
}
