<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use Ramsey\Uuid\UuidInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
class Avatar
{
    protected ?int $id = null;

    public function __construct(
        protected UuidInterface $uuid,
        protected string $contentUrl
    ) {
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

    public function getContentUrl(): string
    {
        return $this->contentUrl;
    }

    public function setContentUrl(string $contentUrl): void
    {
        $this->contentUrl = $contentUrl;
    }
}
