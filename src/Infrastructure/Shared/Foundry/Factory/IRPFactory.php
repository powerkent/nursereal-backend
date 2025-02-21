<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTimeImmutable;
use Nursery\Domain\Shared\Model\IRP;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<IRP>
 *
 * @codeCoverageIgnore
 */
final class IRPFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return IRP::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
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
