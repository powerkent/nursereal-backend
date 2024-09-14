<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTime;
use DateTimeImmutable;
use Nursery\Domain\Shared\Enum\OpeningDays;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Model\NurseryStructureOpening;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<NurseryStructure>
 */
final class NurseryStructureFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return NurseryStructure::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'uuid' => Uuid::uuid4(),
            'name' => self::faker()->company(),
            'address' => self::faker()->address(),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'updatedAt' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTime()) : null,
        ];
    }

    protected function initialize(): static
    {
        return $this->afterInstantiate(function (NurseryStructure $nurseryStructure) {
            $nurseryStructure->setNurseryStructureOpenings(
                [
                    new NurseryStructureOpening(
                        openingHour: new DateTime('2024-10-01 08:00:00'),
                        closingHour: new DateTime('2024-10-01 18:00:00'),
                        openingDay: OpeningDays::Monday,
                        nurseryStructure: $nurseryStructure,
                    ),
                    new NurseryStructureOpening(
                        openingHour: new DateTime('2024-10-01 08:00:00'),
                        closingHour: new DateTime('2024-10-01 18:00:00'),
                        openingDay: OpeningDays::Tuesday,
                        nurseryStructure: $nurseryStructure,
                    ),
                    new NurseryStructureOpening(
                        openingHour: new DateTime('2024-10-01 08:00:00'),
                        closingHour: new DateTime('2024-10-01 18:00:00'),
                        openingDay: OpeningDays::Wednesday,
                        nurseryStructure: $nurseryStructure,
                    ),
                    new NurseryStructureOpening(
                        openingHour: new DateTime('2024-10-01 08:00:00'),
                        closingHour: new DateTime('2024-10-01 18:00:00'),
                        openingDay: OpeningDays::Thursday,
                        nurseryStructure: $nurseryStructure,
                    ),
                    new NurseryStructureOpening(
                        openingHour: new DateTime('2024-10-01 08:00:00'),
                        closingHour: new DateTime('2024-10-01 18:00:00'),
                        openingDay: OpeningDays::Friday,
                        nurseryStructure: $nurseryStructure,
                    ),
                ]
            );
        });
    }
}