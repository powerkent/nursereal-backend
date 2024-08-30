<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model\Action;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Nursery\Enum\CareType;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping as ORM;

class Care extends Action
{
    #[ORM\Column(type: 'care_type_array')]
    /* @phpstan-ignore-next-line */
    protected array $types = [];

    /**
     * @param array<int, Child>|Collection<int, Child> $children
     * @param array<int, CareType>                     $types
     */
    public function __construct(
        UuidInterface $uuid,
        DateTimeInterface $createdAt,
        ?DateTimeInterface $updatedAt,
        Collection|array $children,
        ?string $comment,
        array $types = [],
    ) {
        parent::__construct(
            uuid: $uuid,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            children: $children,
            comment: $comment,
        );

        $this->types = $types;
    }

    /**
     * @return array<int, CareType>
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * @param array<int, CareType> $types
     */
    public function setTypes(array $types): self
    {
        $this->types = $types;

        return $this;
    }
}
