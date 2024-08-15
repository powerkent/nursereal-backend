<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Nursery\Domain\Nursery\Model\Child;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractAction
{
    protected ?int $id = null;

    /** @var Collection<int, Child> */
    protected Collection $children;

    /**
     * @param array<int, Child>|Collection<int, Child> $children
     */
    public function __construct(
        protected UuidInterface $uuid,
        protected DateTimeInterface $createdAt,
        Collection|array $children,
        protected ?string $comment = null,
    ) {
        $this->children = is_array($children) ? new ArrayCollection($children) : $children;
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

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $dateTime): self
    {
        $this->createdAt = $dateTime;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection<int, Child>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    /**
     * @param array<int, Child>|Collection<int, Child> $children
     */
    public function setChildren(Collection|array $children): self
    {
        $this->children = $children instanceof Collection ? $children : new ArrayCollection($children);

        return $this;
    }

    public function addChild(Child $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
        }

        return $this;
    }

    public function removeChild(Child $child): self
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
        }

        return $this;
    }
}
