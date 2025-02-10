<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use Nursery\Domain\Shared\Enum\AvatarType;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
class Avatar
{
    protected ?int $id = null;

    public function __construct(
        protected AvatarType $type,
        protected string $contentUrl
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getType(): AvatarType
    {
        return $this->type;
    }

    public function setType(AvatarType $type): void
    {
        $this->type = $type;
    }

    public function getContentUrl(): string
    {
        return $this->contentUrl;
    }

    public function setContentUrl(string $contentUrl): self
    {
        $this->contentUrl = $contentUrl;

        return $this;
    }
}
