<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use Faker\Generator;
use Nursery\Domain\Shared\Model\Config;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Config>
 *
 * @codeCoverageIgnore
 */
final class ConfigFactory extends PersistentProxyObjectFactory
{
    private const array NAME = [
        'AGENT_LOGIN_WITH_PHONE',
    ];

    public static function class(): string
    {
        return Config::class;
    }

    protected function defaults(): array|callable
    {
        /** @var Generator $uniqueGenerator */
        $uniqueGenerator = self::faker()->unique();

        return [
            'uuid' => Uuid::fromString($uniqueGenerator->uuid()),
            'name' => self::faker()->randomElement(self::NAME),
            'value' => self::faker()->boolean(),
        ];
    }
}
