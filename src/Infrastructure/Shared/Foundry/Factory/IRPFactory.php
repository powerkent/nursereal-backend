<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTimeImmutable;
use Nursery\Domain\Shared\Model\IRP;

/**
 * @extends AbstractModelFactory<IRP>
 *
 * @codeCoverageIgnore
 */
final class IRPFactory extends AbstractModelFactory
{
    public static function class(): string
    {
        return IRP::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->name(),
            'description' => self::faker()->text(),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-5 days')),
            'startAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-5 days', '+7 days')),
            'endAt' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('+7 days', '+14 days')) : null,
        ];
    }
}
