<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateMalformedStringException;
use DateTimeImmutable;
use Nursery\Domain\Shared\Model\AgeGroup;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<AgeGroup>
 *
 * @codeCoverageIgnore
 */
final class AgeGroupFactory extends PersistentProxyObjectFactory
{
    private const array AGE_GROUPS = [
        [
            'name' => 'baby',
            'adultChildRatio' => 2,
            'minAge' => 0,
            'maxAge' => 12,
        ],
        [
            'name' => 'Young children',
            'adultChildRatio' => 4,
            'minAge' => 12,
            'maxAge' => 24,
        ],
        [
            'name' => 'Preschoolers',
            'adultChildRatio' => 6,
            'minAge' => 24,
            'maxAge' => null,
        ],
    ];

    public static function class(): string
    {
        return AgeGroup::class;
    }

    /**
     * @return array<string, mixed>
     * @throws DateMalformedStringException
     */
    protected function defaults(): array
    {
        $element = self::faker()->randomElement(self::AGE_GROUPS);
        $createdAt = DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-60 days'));
        $updatedAt = null;
        if (self::faker()->boolean()) {
            $now = new DateTimeImmutable('now');
            $intervalDays = $now->diff($createdAt)->days;
            $number = self::faker()->numberBetween(0, $intervalDays);
            $updatedAt = (clone $createdAt)->modify("+$number days");
        }

        return [
            'uuid' => Uuid::uuid4(),
            'name' => $element['name'],
            'adultChildRatio' => $element['adultChildRatio'],
            'minAge' => $element['minAge'],
            'createdAt' => $createdAt,
            'updatedAt' => $updatedAt,
            'maxAge' => $element['maxAge'],
        ];
    }
}
