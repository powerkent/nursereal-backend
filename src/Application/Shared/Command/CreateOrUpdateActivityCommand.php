<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Command;

final class CreateOrUpdateActivityCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): static
    {
        return new self($primitives);
    }
}
