<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTimeImmutable;
use Faker\Generator;
use Nursery\Domain\Shared\Enum\ClockingInState;
use Nursery\Domain\Shared\Model\ClockingIn;
use Ramsey\Uuid\Uuid;

/**
 * @extends AbstractModelFactory<ClockingIn>
 *
 * @codeCoverageIgnore
 */
final class ClockingInFactory extends AbstractModelFactory
{
    public static function class(): string
    {
        return ClockingIn::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        /** @var Generator $uniqueGenerator */
        $uniqueGenerator = self::faker()->unique();

        $dateTime = self::faker()->dateTimeBetween('-5 days');
        $startHour = self::faker()->numberBetween(6, 14);
        $startDateTime = $dateTime->setTime($startHour, 0);
        $endDateTime = clone $startDateTime;
        $now = new DateTimeImmutable();
        if (($hour = $startHour + 7) > 19) {
            $hour = 19;
        }
        $state = ClockingInState::Done;
        if ($startDateTime->format('Y-m-d') === $now->format('Y-m-d') && $hour < $now->format('H')) {
            $endDateTime->setTime($hour, 0);
        } elseif ($startDateTime->format('Y-m-d') === $now->format('Y-m-d')) {
            $endDateTime = null;
            $state = ClockingInState::InProgress;
        } else {
            $endDateTime->setTime($hour, 0);
        }

        return [
            'uuid' => Uuid::fromString($uniqueGenerator->uuid()),
            'state' => $state,
            'agent' => $agent = AgentFactory::random(),
            'nurseryStructure' => current($agent->getNurseryStructures()->toArray()),
            'startDateTime' => $startDateTime,
            'endDateTime' => $endDateTime,
        ];
    }
}
