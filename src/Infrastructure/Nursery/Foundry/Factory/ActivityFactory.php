<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory;

use DateTimeImmutable;
use Nursery\Domain\Nursery\Model\Activity;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Activity>
 */
final class ActivityFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Activity::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'uuid' => Uuid::uuid4(),
            'name' => self::faker()->word(),
            'description' => self::faker()->sentence(),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'updatedAt' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTime()) : null,
        ];
    }
}
