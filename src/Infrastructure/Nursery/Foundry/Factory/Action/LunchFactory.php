<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory\Action;

use Nursery\Domain\Nursery\Model\Action\Lunch;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActionFactory;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Lunch>
 *
 * @codeCoverageIgnore
 */
final class LunchFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Lunch::class;
    }

    protected function defaults(): array|callable
    {
        return new ActionFactory()->defaults();
    }
}
