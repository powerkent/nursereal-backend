<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Nursery\Domain\Shared\Model\Activity;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

class Child
{
    protected ?int $id = null;

    /** @var Collection<int, Treatment> */
    protected Collection $treatments;

    /** @var Collection<int, Treatment> */
    protected Collection $activities;

    /**
     * @param array<int, Treatment>|Collection<int, Treatment> $treatments
     * @param array<int, Activity>|Collection<int, Activity>   $activities
     */
    public function __construct(
        protected UuidInterface $uuid,
        protected string $firstname,
        protected string $lastname,
        protected DateTimeInterface $birthday,
        protected DateTimeInterface $createdAt,
        protected ?IRP $irp = null,
        array|Collection $treatments = [],
        array|Collection $activities = [],
    ) {
        Assert::stringNotEmpty($firstname);
        Assert::stringNotEmpty($lastname);

        $this->treatments = is_array($treatments) ? new ArrayCollection($treatments) : $treatments;
        $this->activities = is_array($activities) ? new ArrayCollection($activities) : $activities;
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

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthday(): DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

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

    public function getIrp(): ?IRP
    {
        return $this->irp;
    }

    public function setIrp(?IRP $irp): self
    {
        $this->irp = $irp;

        return $this;
    }

    public function getTreatments(): ?Collection
    {
        return $this->treatments;
    }

    /**
     * @param array<int, Treatment>|Collection<int, Treatment> $treatments
     */
    public function setTreatments(Collection|array $treatments): self
    {
        $this->treatments = $treatments instanceof Collection ? $treatments : new ArrayCollection($treatments);

        return $this;
    }

    public function addTreatment(Treatment $treatment): self
    {
        if (!$this->treatments->contains($treatment)) {
            $this->treatments->add($treatment);
            $treatment->setChild($this);
        }

        return $this;
    }

    public function removeTreatment(Treatment $treatment): self
    {
        if ($this->treatments->contains($treatment)) {
            $this->treatments->removeElement($treatment);
            $treatment->setChild(null);
        }

        return $this;
    }

    public function sortTreatmentsById(): array
    {
        $sortedTreatments = $this->treatments->getValues();
        usort($sortedTreatments, function (Treatment $a, Treatment $b) {
            return $a->getId() > $b->getId();
        });

        return $sortedTreatments;
    }

    public function getActivities(): ?Collection
    {
        return $this->activities;
    }

    /**
     * @param array<int, Activity>|Collection<int, Activity> $activities
     */
    public function setActivities(Collection|array $activities): self
    {
        $this->activities = $activities instanceof Collection ? $activities : new ArrayCollection($activities);

        return $this;
    }

    public function addActivity(Activity $activities): self
    {
        if (!$this->activities->contains($activities)) {
            $this->activities->add($activities);
        }

        return $this;
    }

    public function removeActivity(Activity $activities): self
    {
        if ($this->activities->contains($activities)) {
            $this->activities->removeElement($activities);
        }

        return $this;
    }

    public function sortActivitiesById(): Collection
    {
        $sortedActivities = $this->activities->getValues();
        usort($sortedActivities, function (Activity $a, Activity $b) {
            return $a->getId() > $b->getId();
        });

        return new ArrayCollection($sortedActivities);
    }
}
