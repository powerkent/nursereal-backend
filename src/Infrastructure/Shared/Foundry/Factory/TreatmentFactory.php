<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTimeImmutable;
use Faker\Generator;
use Nursery\Domain\Shared\Model\Treatment;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Treatment>
 *
 * @codeCoverageIgnore
 */
final class TreatmentFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Treatment::class;
    }

    protected function defaults(): array|callable
    {
        /** @var Generator $uniqueGenerator */
        $uniqueGenerator = self::faker()->unique();

        return [
            'uuid' => Uuid::fromString($uniqueGenerator->uuid()),
            'child' => ChildFactory::randomOrCreate(),
            'name' => self::faker()->word(),
            'description' => self::faker()->sentence(),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'startAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'endAt' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTime()) : null,
            'dosages' => [],
        ];
    }
}
