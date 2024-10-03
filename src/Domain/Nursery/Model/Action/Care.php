<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model\Action;

use DateTimeInterface;
use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Shared\Model\Agent;
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
     * @param array<int, CareType> $types
     */
    public function __construct(
        UuidInterface $uuid,
        ActionState $state,
        DateTimeInterface $createdAt,
        ?DateTimeInterface $updatedAt,
        Child $child,
        Agent $agent,
        ?string $comment,
        array $types = [],
    ) {
        parent::__construct(
            uuid: $uuid,
            state: $state,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            child: $child,
            agent: $agent,
            comment: $comment,
        );

        $this->types = $types;
        $this->type = ActionType::Care;
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
