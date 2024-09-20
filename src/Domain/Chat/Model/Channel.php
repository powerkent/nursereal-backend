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
     * @return Collection<int, Message>|null
     */
    public function getMessages(): ?Collection
    {
        return $this->messages;
    }

    /**
     * @param array<int, Message>|Collection<int, Message> $messages
     */
    public function setMessages(Collection|array $messages): self
    {
        $this->messages = $messages instanceof Collection ? $messages : new ArrayCollection($messages);

        return $this;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setChannel($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
        }

        return $this;
    }

    /**
     * @return Collection<int, Member>|null
     */
    public function getMembers(): ?Collection
    {
        return $this->members;
    }

    /**
     * @param array<int, Member>|Collection<int, Member> $members
     */
    public function setMembers(Collection|array $members): self
    {
        $this->members = $members instanceof Collection ? $members : new ArrayCollection($members);

        return $this;
    }

    public function addMember(Member $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
        }

        return $this;
    }

    public function removeMember(Member $member): self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
        }

        return $this;
    }
}
