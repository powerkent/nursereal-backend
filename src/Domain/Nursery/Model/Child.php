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

    /** @var Collection<int, Customer> */
    protected Collection $customers;

    /** @var Collection<int, Activity> */
    protected Collection $activities;

    /**
     * @param array<int, Treatment>|Collection<int, Treatment> $treatments
     * @param array<int, Customer>|Collection<int, Customer>   $customers
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
        array|Collection $customers = [],
        array|Collection $activities = [],
    ) {
        Assert::stringNotEmpty($firstname);
        Assert::stringNotEmpty($lastname);

        $this->treatments = is_array($treatments) ? new ArrayCollection($treatments) : $treatments;
        $this->customers = is_array($customers) ? new ArrayCollection($customers) : $customers;
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

    /**
     * @return Collection<int, Treatment>|null
     */
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

    /**
     * @return Collection<int, Customer>
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    /**
     * @param array<int, Customer>|Collection<int, Customer> $customers
     */
    public function setCustomers(Collection|array $customers): self
    {
        $this->customers = $customers instanceof Collection ? $customers : new ArrayCollection($customers);

        return $this;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers->add($customer);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->contains($customer)) {
            $this->customers->removeElement($customer);
        }

        return $this;
    }

    /**
     * @return Collection<int, Activity>|null
     */
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
}
