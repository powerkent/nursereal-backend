<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory\Action;

use Nursery\Domain\Nursery\Model\Action\Milk;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActionFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\AbstractModelFactory;

/**
 * @extends AbstractModelFactory<Milk>
 *
 * @codeCoverageIgnore
 */
final class MilkFactory extends AbstractModelFactory
{
    public static function class(): string
    {
        return Milk::class;
    }

    protected function defaults(): array|callable
    {
        return new ActionFactory()->defaults();
    }
}
