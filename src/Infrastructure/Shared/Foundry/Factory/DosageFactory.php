<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTimeImmutable;
use Nursery\Domain\Shared\Model\Dosage;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Dosage>
 */
final class DosageFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Dosage::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'treatment' => TreatmentFactory::random(),
            'dose' => self::faker()->word(),
            'dosingTime' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }
}
