<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Model\Action;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Nursery\Model\AbstractAction;
use Nursery\Domain\Nursery\Enum\CareType;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping as ORM;

class Care extends AbstractAction
{
    #[ORM\Column(type: 'care_type_array')]
    /* @phpstan-ignore-next-line */
    protected array $careTypes = [];

    /**
     * @param array<int, Child>|Collection<int, Child> $children
     * @param array<int, CareType>                     $careTypes
     */
    public function __construct(
        UuidInterface $uuid,
        DateTimeInterface $createdAt,
        Collection|array $children,
        ?string $comment,
        array $careTypes = [],
    ) {
        parent::__construct(
            uuid: $uuid,
            createdAt: $createdAt,
            children: $children,
            comment: $comment,
        );

        $this->careTypes = $careTypes;
    }

    /**
     * @return array<int, CareType>
     */
    public function getCareTypes(): array
    {
        return $this->careTypes;
    }

    /**
     * @param array<int, CareType> $careTypes
     */
    public function setCareTypes(array $careTypes): self
    {
        $this->careTypes = $careTypes;

        return $this;
    }
}
