<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Customer;

use Nursery\Domain\Shared\Command\CommandInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class DeleteCustomerByUuidCommand implements CommandInterface
{
    public function __construct(public UuidInterface|string $uuid)
    {
    }
}
