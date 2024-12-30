<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTime;
use DateTimeImmutable;
use Faker\Generator;
use Nursery\Domain\Shared\Enum\OpeningDays;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Model\NurseryStructureOpening;
use Ramsey\Uuid\Uuid;

/**
 * @extends AbstractModelFactory<NurseryStructure>
 *
 * @codeCoverageIgnore
 */
final class NurseryStructureFactory extends AbstractModelFactory
{
    public static function class(): string
    {
        return NurseryStructure::class;
    }

    protected function defaults(): array|callable
    {
        /** @var Generator $uniqueGenerator */
        $uniqueGenerator = self::faker()->unique();

        return [
            'uuid' => Uuid::fromString($uniqueGenerator->uuid()),
            'name' => self::faker()->company(),
            'address' => self::faker()->address(),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-5 days')),
            'updatedAt' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-5 days')) : null,
        ];
    }

    protected function initialize(): static
    {
        return $this->afterInstantiate(function (NurseryStructure $nurseryStructure) {
            $nurseryStructure->setNurseryStructureOpenings(
                [
                    new NurseryStructureOpening(
                        openingHour: (new DateTime())->setTime(7, 0),
                        closingHour: (new DateTime())->setTime(19, 0),
                        openingDay: OpeningDays::Monday,
                        nurseryStructure: $nurseryStructure,
                    ),
                    new NurseryStructureOpening(
                        openingHour: (new DateTime())->setTime(7, 0),
                        closingHour: (new DateTime())->setTime(19, 0),
                        openingDay: OpeningDays::Tuesday,
                        nurseryStructure: $nurseryStructure,
                    ),
                    new NurseryStructureOpening(
                        openingHour: (new DateTime())->setTime(7, 0),
                        closingHour: (new DateTime())->setTime(19, 0),
                        openingDay: OpeningDays::Wednesday,
                        nurseryStructure: $nurseryStructure,
                    ),
                    new NurseryStructureOpening(
                        openingHour: (new DateTime())->setTime(7, 0),
                        closingHour: (new DateTime())->setTime(19, 0),
                        openingDay: OpeningDays::Thursday,
                        nurseryStructure: $nurseryStructure,
                    ),
                    new NurseryStructureOpening(
                        openingHour: (new DateTime())->setTime(7, 0),
                        closingHour: (new DateTime())->setTime(19, 0),
                        openingDay: OpeningDays::Friday,
                        nurseryStructure: $nurseryStructure,
                    ),
                ]
            );
        });
    }
}
