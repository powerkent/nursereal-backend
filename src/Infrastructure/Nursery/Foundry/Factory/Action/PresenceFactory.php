<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory\Action;

use Nursery\Domain\Nursery\Model\Action\Presence;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActionFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\AbstractModelFactory;

/**
 * @extends AbstractModelFactory<Presence>
 *
 * @codeCoverageIgnore
 */
final class PresenceFactory extends AbstractModelFactory
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
