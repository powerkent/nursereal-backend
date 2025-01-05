<?php

declare(strict_types=1);

namespace Nursery\Domain\Chat\Model;

use DateTimeInterface;

class Message
{
    protected ?int $id = null;

    public function __construct(
        protected string $content,
        protected Member $author,
        protected Channel $channel,
        protected DateTimeInterface $createdAt,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): Member
    {
        return $this->author;
    }

    public function getChannel(): Channel
    {
        return $this->channel;
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
}
