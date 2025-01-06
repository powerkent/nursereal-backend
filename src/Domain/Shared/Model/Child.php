<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

class Child
{
    protected ?int $id = null;

    /** @var Collection<int, Treatment> */
    protected Collection $treatments;

    /** @var Collection<int, Customer> */
    protected Collection $customers;

    /** @var Collection<int, ContractDate> */
    protected Collection $contractDates;

    /**
     * @param array<int, Treatment>|Collection<int, Treatment>       $treatments
     * @param array<int, Customer>|Collection<int, Customer>         $customers
     * @param array<int, ContractDate>|Collection<int, ContractDate> $contractDates
     */
    public function __construct(
        protected UuidInterface $uuid,
        protected ?Avatar $avatar,
        protected string $firstname,
        protected string $lastname,
        protected DateTimeInterface $birthday,
        protected NurseryStructure $nurseryStructure,
        protected DateTimeInterface $createdAt,
        protected ?DateTimeInterface $updatedAt = null,
        protected ?IRP $irp = null,
        array|Collection $treatments = [],
        array|Collection $customers = [],
        array|Collection $contractDates = [],
    ) {
        Assert::stringNotEmpty($firstname);
        Assert::stringNotEmpty($lastname);

        $this->treatments = is_array($treatments) ? new ArrayCollection($treatments) : $treatments;
        $this->customers = is_array($customers) ? new ArrayCollection($customers) : $customers;
        $this->contractDates = is_array($contractDates) ? new ArrayCollection($contractDates) : $contractDates;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
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

    public function getNurseryStructure(): NurseryStructure
    {
        return $this->nurseryStructure;
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
     * @return Collection<int, ContractDate>
     */
    public function getContractDates(): Collection
    {
        return $this->contractDates;
    }

    /**
     * @param array<int, ContractDate>|Collection<int, ContractDate> $contractDates
     */
    public function setContractDates(Collection|array $contractDates): self
    {
        $this->contractDates = $contractDates instanceof Collection ? $contractDates : new ArrayCollection($contractDates);

        return $this;
    }

    public function addContractDate(ContractDate $contractDate): self
    {
        if (!$this->contractDates->contains($contractDate)) {
            $this->contractDates->add($contractDate);
        }

        return $this;
    }
}
