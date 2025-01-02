<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory\Action;

use Nursery\Domain\Nursery\Model\Action\Rest;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActionFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\AbstractModelFactory;

/**
 * @extends AbstractModelFactory<Rest>
 *
 * @codeCoverageIgnore
 */
final class RestFactory extends AbstractModelFactory
{
    public static function class(): string
    {
        return Rest::class;
    }

    protected function defaults(): array|callable
    {
        return (new ActionFactory())->defaults();
    }
}
