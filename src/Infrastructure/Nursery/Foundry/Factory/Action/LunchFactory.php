<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory\Action;

use Nursery\Domain\Nursery\Model\Action\Lunch;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActionFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\AbstractModelFactory;

/**
 * @extends AbstractModelFactory<Lunch>
 *
 * @codeCoverageIgnore
 */
final class LunchFactory extends AbstractModelFactory
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
