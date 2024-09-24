<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use Nursery\Domain\Shared\Model\ContractDate;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<ContractDate>
 */
final class ContractDateFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return ContractDate::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'contractTimeStart' => self::faker()->dateTime(),
            'contractTimeEnd' => self::faker()->dateTime(),
            'child' => ChildFactory::randomOrCreate(),
        ];
    }
}
