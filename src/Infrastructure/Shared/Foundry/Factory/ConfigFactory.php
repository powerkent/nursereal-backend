<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use Nursery\Domain\Shared\Model\Config;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Config>
 */
final class ConfigFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Config::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'uuid' => Uuid::uuid4(),
            'name' => self::faker()->name(),
            'value' => self::faker()->boolean(),
        ];
    }
}
