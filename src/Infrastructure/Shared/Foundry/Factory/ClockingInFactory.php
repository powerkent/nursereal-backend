<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTimeImmutable;
use Faker\Generator;
use Nursery\Domain\Shared\Enum\ClockingInState;
use Nursery\Domain\Shared\Model\ClockingIn;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<ClockingIn>
 *
 * @codeCoverageIgnore
 */
final class ClockingInFactory extends PersistentProxyObjectFactory
{
    /**
     * @var array<string, bool>
     */
    /** @phpstan-ignore-next-line  */
    private static array $usedDates = [];

    public static function class(): string
    {
        return ClockingIn::class;
    }

    protected function defaults(): callable
    {
        return function () {
            /** @var Generator $uniqueGenerator */
            $uniqueGenerator = self::faker()->unique();
            $agent = AgentFactory::random();
            $nurseryStructure = current($agent->getNurseryStructures()->toArray());
            do {
                $dateTime = self::faker()->dateTimeBetween('-5 days');
                $startHour = self::faker()->numberBetween(6, 16);
                $startDateTime = $dateTime->setTime($startHour, 0);
                $endDateTime = clone $startDateTime;
                $now = new DateTimeImmutable();
                if (($hour = $startHour + 4) > 19) {
                    $hour = 19;
                }
                $state = ClockingInState::Done;
                if ($startDateTime->format('Y-m-d') === $now->format('Y-m-d')) {
                    $endDateTime = null;
                    $state = ClockingInState::InProgress;
                } else {
                    $endDateTime->setTime($hour, 0);
                }

                $key = "{$agent->getId()}_{$startDateTime->format('Y-m-d')}_".(null !== $endDateTime ? "_{$endDateTime->format('Y-m-d')}" : '');
            } while (isset(self::$usedDates[$key]) && $endDateTime < $startDateTime);

            self::$usedDates[$key] = true;

            return [
                'uuid'             => Uuid::fromString($uniqueGenerator->uuid()),
                'state'            => $state,
                'agent'            => $agent,
                'nurseryStructure' => $nurseryStructure,
                'startDateTime'    => $startDateTime,
                'endDateTime'      => $endDateTime,
            ];
        };
    }
}
