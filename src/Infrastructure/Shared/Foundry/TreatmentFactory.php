<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry;

use DateTimeImmutable;
use Nursery\Domain\Shared\Model\Treatment;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Treatment>
 */
final class TreatmentFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Treatment::class;
    }
    protected function defaults(): array|callable
    {
        return [
            'uuid' => Uuid::uuid4(),
            'child' => ChildFactory::randomOrCreate(),
            'name' => self::faker()->name(),
            'description' => self::faker()->sentence(),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'startAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'endAt' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTime()) : null,
            'dosages' => [],

        ];
    }

    protected function initialize(): static
    {
        return $this->afterInstantiate(function (Treatment $treatment) {
            $numberOfDosages = self::faker()->numberBetween(0, 5);

            if ($numberOfDosages > 0) {
                $dosages = DosageFactory::new()->createMany($numberOfDosages, ['treatment' => $treatment]);
                $treatment->setDosages($dosages);
            }
        });
    }
}
