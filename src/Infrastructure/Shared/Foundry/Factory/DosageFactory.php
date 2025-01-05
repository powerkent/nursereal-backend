<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTimeImmutable;
use Nursery\Domain\Shared\Model\Dosage;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Dosage>
 *
 * @codeCoverageIgnore
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
            'dose' => self::faker()->boolean() ? self::faker()->word() : null,
            'dosingTime' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTime()) : null,
        ];
    }
}
