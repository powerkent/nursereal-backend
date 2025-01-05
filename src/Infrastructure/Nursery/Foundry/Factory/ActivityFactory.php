<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory;

use DateTimeImmutable;
use Faker\Generator;
use Nursery\Domain\Nursery\Model\Activity;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Activity>
 *
 * @codeCoverageIgnore
 */
final class ActivityFactory extends PersistentProxyObjectFactory
{
    private const array ACTIVITIES = [
        'Comptines',
        'Instruments de musique',
        'Tapis d’éveil',
        'Pâte à modeler',
        'Transvasement',
        'Peinture',
    ];

    public static function class(): string
    {
        return Activity::class;
    }

    protected function defaults(): array|callable
    {
        /** @var Generator $uniqueGenerator */
        $uniqueGenerator = self::faker()->unique();

        return [
            'uuid' => Uuid::fromString($uniqueGenerator->uuid()),
            'name' => self::faker()->randomElement(self::ACTIVITIES),
            'description' => self::faker()->sentence(),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'updatedAt' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTime()) : null,
        ];
    }
}
