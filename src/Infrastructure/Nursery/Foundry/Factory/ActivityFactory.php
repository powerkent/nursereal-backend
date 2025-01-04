<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory;

use DateTimeImmutable;
use Faker\Generator;
use Nursery\Domain\Nursery\Model\Activity;
use Nursery\Infrastructure\Shared\Foundry\Factory\AbstractModelFactory;
use Ramsey\Uuid\Uuid;

/**
 * @extends AbstractModelFactory<Activity>
 *
 * @codeCoverageIgnore
 */
final class ActivityFactory extends AbstractModelFactory
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

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
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
