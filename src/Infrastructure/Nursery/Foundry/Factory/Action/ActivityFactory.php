<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory\Action;

use Nursery\Domain\Nursery\Model\Action\Activity;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActionFactory;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActivityFactory as WhatActivityFactory;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Activity>
 *
 * @codeCoverageIgnore
 */
final class ActivityFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Activity::class;
    }

    protected function defaults(): array|callable
    {
        return array_merge(new ActionFactory()->defaults(), ['activity' => WhatActivityFactory::randomOrCreate()]);
    }
}
