<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTimeImmutable;
use Nursery\Domain\Shared\Model\Dosage;

/**
 * @extends AbstractModelFactory<Dosage>
 *
 * @codeCoverageIgnore
 */
final class DosageFactory extends AbstractModelFactory
{
    public static function class(): string
    {
        return Dosage::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'treatment' => TreatmentFactory::random(),
            'dose' => self::faker()->boolean() ? self::faker()->word() : null,
            'dosingTime' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTime()) : null,
        ];
    }
}
