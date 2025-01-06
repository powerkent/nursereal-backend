<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Customer;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateCustomerCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): CreateCustomerCommand
    {
        return new self($primitives);
    }
}
