<?php

declare(strict_types=1);

namespace Nursery\Domain\Chat\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use function is_array;

class Channel
{
    protected ?int $id = null;

    /** @var Collection<int, Message> */
    protected Collection $messages;

    /** @var Collection<int, Member> */
    protected Collection $members;

    /**
     * @param Collection<int, Member>|array<int, Member>   $members
     * @param Collection<int, Message>|array<int, Message> $messages
     */
    public function __construct(
        protected string $name,
        protected DateTimeInterface $createdAt,
        Collection|array $members = [],
        Collection|array $messages = [],
    ) {
        $this->members = is_array($members) ? new ArrayCollection($members) : $members;
        $this->messages = is_array($messages) ? new ArrayCollection($messages) : $messages;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    /**
     * @return Collection<int, Member>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }
}
