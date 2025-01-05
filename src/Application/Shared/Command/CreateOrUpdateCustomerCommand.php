<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateOrUpdateCustomerCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): CreateOrUpdateCustomerCommand
    {
        return new self($primitives);
    }
}
