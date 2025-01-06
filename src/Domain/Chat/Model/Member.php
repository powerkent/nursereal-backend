<?php

declare(strict_types=1);

namespace Nursery\Domain\Chat\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Nursery\Domain\Chat\Enum\MemberType;

class Member
{
    protected ?int $id = null;

    /** @var Collection<int, Channel> */
    protected Collection $channels;

    /**
     * @param Collection<int, Channel>|array<int, Channel> $channels
     */
    public function __construct(
        protected MemberType $type,
        protected int $memberId,
        Collection|array $channels = []
    ) {
        $this->channels = $channels instanceof Collection ? $channels : new ArrayCollection($channels);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): MemberType
    {
        return $this->type;
    }

    public function setType(MemberType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMemberId(): int
    {
        return $this->memberId;
    }

    public function setMemberId(int $memberId): self
    {
        $this->memberId = $memberId;

        return $this;
    }

    /**
     * @return Collection<int, Channel>
     */
    public function getChannels(): Collection
    {
        return $this->channels;
    }

    /**
     * @param array<int, Channel>|Collection<int, Channel> $channels
     */
    public function setChannels(Collection|array $channels): self
    {
        $this->channels = $channels instanceof Collection ? $channels : new ArrayCollection($channels);

        return $this;
    }

    public function addChannel(Channel $channel): self
    {
        if (!$this->channels->contains($channel)) {
            $this->channels->add($channel);
        }

        return $this;
    }

    public function removeChannel(Channel $channel): self
    {
        if ($this->channels->contains($channel)) {
            $this->channels->removeElement($channel);
        }

        return $this;
    }
}
