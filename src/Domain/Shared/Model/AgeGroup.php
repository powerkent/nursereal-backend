<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

class AgeGroup
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
        protected int $adultChildRatio,
        protected int $minAge,
        protected DateTimeInterface $createdAt,
        protected ?DateTimeInterface $updatedAt = null,
        protected ?int $maxAge = null,
        array|Collection $nurseryStructures = [],
    ) {
        Assert::greaterThanEq($minAge, 0, 'The minimum age must be greater or equal than 0.');
        if (null !== $maxAge) {
            Assert::greaterThan($maxAge, 0, 'The maximum age must be greater than 0.');
            Assert::greaterThan($maxAge, $minAge, 'The maximum age must be greater than the minimum age.');
        }
        Assert::greaterThan($adultChildRatio, 0, 'The maximum age must be greater than the minimum age.');

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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAdultChildRatio(): int
    {
        return $this->adultChildRatio;
    }

    public function setAdultChildRatio(int $adultChildRatio): self
    {
        $this->adultChildRatio = $adultChildRatio;

        return $this;
    }

    public function getMinAge(): int
    {
        return $this->minAge;
    }

    public function setMinAge(int $minAge): self
    {
        $this->minAge = $minAge;

        if (null !== $this->maxAge) {
            Assert::greaterThan($this->maxAge, $this->minAge, 'The maximum age must be greater than the minimum age.');
        }

        return $this;
    }

    public function getMaxAge(): ?int
    {
        return $this->maxAge;
    }

    public function setMaxAge(?int $maxAge): self
    {
        if (null !== $maxAge) {
            Assert::greaterThan($maxAge, $this->minAge, 'The maximum age must be greater than the minimum age.');
        }

        $this->maxAge = $maxAge;

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

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, NurseryStructure>
     */
    public function getNurseryStructures(): Collection
    {
        return $this->nurseryStructures;
    }

    public function addNurseryStructure(NurseryStructure $nurseryStructure): self
    {
        if (!$this->nurseryStructures->contains($nurseryStructure)) {
            $this->nurseryStructures->add($nurseryStructure);
        }

        return $this;
    }

    public function removeNurseryStructures(NurseryStructure $nurseryStructures): self
    {
        $this->nurseryStructures->removeElement($nurseryStructures);

        return $this;
    }

}
