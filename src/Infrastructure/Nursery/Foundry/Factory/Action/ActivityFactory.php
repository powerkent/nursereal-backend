<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory\Action;

use Nursery\Domain\Nursery\Model\Action\Activity;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActionFactory;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActivityFactory as WhatActivityFactory;

/**
 * @codeCoverageIgnore
 */
final class ActivityFactory extends ActionFactory
{
    protected function defaults(): array
    {
        return array_merge(parent::defaults(), [
            'activity' => WhatActivityFactory::randomOrCreate(),
        ]);
    }

    public static function class(): string
    {
        return Activity::class;
    }
}
