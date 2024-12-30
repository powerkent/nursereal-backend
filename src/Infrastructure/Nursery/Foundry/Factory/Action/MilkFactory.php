<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory\Action;

use Nursery\Domain\Nursery\Model\Action\Milk;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActionFactory;

/**
 * @codeCoverageIgnore
 */
final class MilkFactory extends ActionFactory
{
    protected function defaults(): array
    {
        return array_merge(parent::defaults(), [
            'quantity' => self::faker()->boolean() ? self::faker()->randomNumber().' mL' : null,
        ]);
    }

    public static function class(): string
    {
        return Milk::class;
    }
}
