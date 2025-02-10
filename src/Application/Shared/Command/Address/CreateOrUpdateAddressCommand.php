<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Address;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateOrUpdateAddressCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): CreateOrUpdateAddressCommand
    {
        return new self($primitives);
    }
}
