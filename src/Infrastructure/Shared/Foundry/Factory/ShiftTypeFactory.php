<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTimeImmutable;
use Nursery\Domain\Shared\Model\ShiftType;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<ShiftType>
 *
 * @codeCoverageIgnore
 */
final class ShiftTypeFactory extends PersistentProxyObjectFactory
{
    /**
     * @var array<string, bool>
     */
    /** @phpstan-ignore-next-line  */
    private static array $usedData = [];

    /**
     * @var array<int, array<string, string>>
     */
    /** @phpstan-ignore-next-line  */
    private static array $usedTimes = [
        [
            'name' => 'Morning',
            'arrivalTime' => '06:45:00',
            'endOfWorkTime' => '15:00:00',
            'breakTime' => '11:30:00',
            'endOfBreakTime' => '12:00:00',
        ],
        [
            'name' => 'Day',
            'arrivalTime' => '08:00:00',
            'endOfWorkTime' => '17:00:00',
            'breakTime' => '12:00:00',
            'endOfBreakTime' => '14:00:00',
        ],
        [
            'name' => 'Afternoon',
            'arrivalTime' => '11:30:00',
            'endOfWorkTime' => '19:00:00',
            'breakTime' => '13:30:00',
            'endOfBreakTime' => '14:00:00',
        ],
    ];

    public static function class(): string
    {
        return ShiftType::class;
    }

    protected function defaults(): callable
    {
        return function () {
            do {
                $key = self::faker()->numberBetween(0, 2);
            } while (isset(self::$usedData[$key]));

            self::$usedData[$key] = true;

            return [
                'uuid' => Uuid::uuid4(),
                'name' => self::$usedTimes[$key]['name'],
                'arrivalTime' => new DateTimeImmutable(self::$usedTimes[$key]['arrivalTime']),
                'endOfWorkTime' => new DateTimeImmutable(self::$usedTimes[$key]['endOfWorkTime']),
                'breakTime' => new DateTimeImmutable(self::$usedTimes[$key]['breakTime']),
                'endOfBreakTime' => new DateTimeImmutable(self::$usedTimes[$key]['endOfBreakTime']),
                'nurseryStructures' => NurseryStructureFactory::randomRange(1, 5),
            ];
        };
    }
}
