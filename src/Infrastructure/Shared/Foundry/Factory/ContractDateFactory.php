<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use Nursery\Domain\Shared\Model\ContractDate;

/**
 * @extends AbstractModelFactory<ContractDate>
 *
 * @codeCoverageIgnore
 */
final class ContractDateFactory extends AbstractModelFactory
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
            $child = ChildFactory::randomOrCreate();
            do {
                $dateTime = self::faker()->dateTimeBetween('-5 days', '+7 days');

                $contractTimeStart = clone $dateTime;
                $contractTimeEnd = clone $dateTime;

                $startDateKey = $contractTimeStart->format('Y-m-d');
                $endDateKey = $contractTimeEnd->format('Y-m-d');
                $childKey = $child->getId();

                $key = "{$childKey}_{$startDateKey}_{$endDateKey}";
            } while (isset(self::$usedDates[$key]));

            self::$usedDates[$key] = true;

            return [
                'contractTimeStart' => $contractTimeStart->setTime(self::faker()->numberBetween(7, 13), self::faker()->numberBetween(0, 59)),
                'contractTimeEnd' => $contractTimeEnd->setTime(self::faker()->numberBetween(13, 18), self::faker()->numberBetween(0, 59)),
                'child' => $child,
            ];
        };
    }
}
