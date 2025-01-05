<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory\Action;

use Nursery\Domain\Nursery\Model\Action\Presence;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActionFactory;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Presence>
 *
 * @codeCoverageIgnore
 */
final class PresenceFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Presence::class;
    }

    protected function defaults(): array|callable
    {
        return new ActionFactory()->defaults();
    }
}
