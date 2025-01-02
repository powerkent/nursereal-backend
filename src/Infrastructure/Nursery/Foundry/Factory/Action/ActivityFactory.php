<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory\Action;

use Nursery\Domain\Nursery\Model\Action\Activity;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActionFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\AbstractModelFactory;

/**
 * @extends AbstractModelFactory<Activity>
 *
 * @codeCoverageIgnore
 */
final class ActivityFactory extends AbstractModelFactory
{
    public static function class(): string
    {
        return Activity::class;
    }

    protected function defaults(): array|callable
    {
        return (new ActionFactory())->defaults();
    }
}
