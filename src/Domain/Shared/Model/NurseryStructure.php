<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

class NurseryStructure
{
    protected ?int $id = null;

    /** @var Collection<int, Agent> */
    protected Collection $agents;

    /** @var Collection<int, NurseryStructureOpening> */
    protected Collection $openings;

    /**
     * @param array<int, Agent>|Collection<int, Agent>                                     $agents
     * @param array<int, NurseryStructureOpening>|Collection<int, NurseryStructureOpening> $openings
     */
    public function __construct(
        protected UuidInterface $uuid,
        protected string $name,
        protected string $address,
        protected DateTimeInterface $createdAt,
        protected ?DateTimeInterface $updatedAt = null,
        protected ?DateTimeInterface $startAt = null,
        protected ?float $latitude = null,
        protected ?float $longitude = null,
        array|Collection $openings = [],
        array|Collection $agents = [],
    ) {
        Assert::stringNotEmpty($this->name);
        Assert::stringNotEmpty($this->address);

        $this->openings = is_array($openings) ? new ArrayCollection($openings) : $openings;
        $this->agents = is_array($agents) ? new ArrayCollection($agents) : $agents;
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

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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

    public function getStartAt(): ?DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(?DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection<int, NurseryStructureOpening>
     */
    public function getOpenings(): Collection
    {
        return $this->openings;
    }

    /**
     * @param array<int, NurseryStructureOpening>|Collection<int, NurseryStructureOpening> $openings
     */
    public function setOpenings(Collection|array $openings): self
    {
        $this->openings = $openings instanceof Collection ? $openings : new ArrayCollection($openings);

        return $this;
    }

    public function addOpening(NurseryStructureOpening $nurseryStructureOpening): self
    {
        if (!$this->openings->contains($nurseryStructureOpening)) {
            $this->openings->add($nurseryStructureOpening);
        }

        return $this;
    }

    public function removeOpening(NurseryStructureOpening $nurseryStructureOpening): self
    {
        if ($this->openings->contains($nurseryStructureOpening)) {
            $this->openings->removeElement($nurseryStructureOpening);
        }

        return $this;
    }

    /**
     * @return Collection<int, Agent>
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    /**
     * @param Collection<int, Agent> $agents
     */
    public function setAgents(Collection $agents): self
    {
        $this->agents = $agents;

        return $this;
    }

    public function addAgent(Agent $agent): self
    {
        if (!$this->agents->contains($agent)) {
            $this->agents->add($agent);
        }

        return $this;
    }
}
