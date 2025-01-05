<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;

class ContractDate
{
    protected ?int $id = null;

    public function __construct(
        protected DateTimeInterface $contractTimeStart,
        protected DateTimeInterface $contractTimeEnd,
        protected ?Child $child,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContractTimeStart(): DateTimeInterface
    {
        return $this->contractTimeStart;
    }

    public function getContractTimeEnd(): DateTimeInterface
    {
        return $this->contractTimeEnd;
    }

    public function getChild(): ?Child
    {
        return $this->child;
    }
}
