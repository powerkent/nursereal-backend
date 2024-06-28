<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Command;

/**
 * Marker interface for objects allowed to go through the CommandBus.
 *
 * This interface has no default routing,
 * you can use it when you want to apply a custom routing to your command instead of the standard sync/async.
 *
 * @see CommandBusInterface
 * @see CommandInterface
 * @see AsyncCommandInterface
 */
interface RoutableCommandInterface
{
}
