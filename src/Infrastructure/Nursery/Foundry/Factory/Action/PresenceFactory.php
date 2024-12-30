<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory\Action;

use Nursery\Domain\Nursery\Model\Action\Presence;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActionFactory;

/**
 * @codeCoverageIgnore
 */
final class PresenceFactory extends ActionFactory
{
    protected function defaults(): array
    {
        return array_merge(parent::defaults(), [
            'isAbsent' => self::faker()->boolean(),
        ]);
    }

    public static function class(): string
    {
        return Presence::class;
    }
}
