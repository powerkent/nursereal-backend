<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Command;

interface CommandBusInterface
{
    public function dispatch(RoutableCommandInterface $command): mixed;
}
