<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use Nursery\Domain\Shared\Model\ContractDate;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<ContractDate>
 *
 * @codeCoverageIgnore
 */
final class ContractDateFactory extends PersistentProxyObjectFactory
{
    /**
     * @var array<string, bool>
     */
    private static array $usedDates = [];

    public static function class(): string
    {
        return ContractDate::class;
    }

    protected function defaults(): array|callable
    {
        return function () {
            $child = ChildFactory::random();
            do {
                $dateTime = self::faker()->dateTimeBetween('-2 days', '+ 2 days');

                $contractTimeStart = clone $dateTime;
                $contractTimeEnd = clone $dateTime;

                $startDateKey = $contractTimeStart->format('Y-m-d');
                $endDateKey = $contractTimeEnd->format('Y-m-d');
                $childKey = $child->getId();

                $key = "{$childKey}_{$startDateKey}_$endDateKey";
            } while (isset(self::$usedDates[$key]));

            self::$usedDates[$key] = true;

            return [
                'contractTimeStart' => $contractTimeStart->setTime(self::faker()->numberBetween(7, 12), self::faker()->numberBetween(0, 59)),
                'contractTimeEnd' => $contractTimeEnd->setTime(self::faker()->numberBetween(14, 18), self::faker()->numberBetween(0, 59)),
                'child' => $child,
            ];
        };
    }
}
