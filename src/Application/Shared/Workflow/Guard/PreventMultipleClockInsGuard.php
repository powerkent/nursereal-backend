<?php


declare(strict_types=1);

namespace Nursery\Application\Shared\Workflow\Guard;

use DateTimeImmutable;
use Nursery\Application\Shared\Query\ClockingIn\FindClockInsByFiltersQuery;
use Nursery\Domain\Shared\Enum\ClockingInState;
use Nursery\Domain\Shared\Enum\ClockingInTransition;
use Nursery\Domain\Shared\Listener\GuardInterface;
use Nursery\Domain\Shared\Model\ClockingIn;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use RuntimeException;

final class PreventMultipleClockInsGuard implements GuardInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    /**
     * @param ClockingIn $clockingIn
     */
    public function handle(object $clockingIn): ?RuntimeException
    {
        $start = new DateTimeImmutable()->setTime(0, 0);
        $end = new DateTimeImmutable()->setTime(23, 59, 59);

        $clockIns = $this->queryBus->ask(new FindClockInsByFiltersQuery([
            'startDateTime' => $start,
            'endDateTime' => $end,
            'agents' => [$clockingIn->getAgent()],
            'nurseryStructures' => [$clockingIn->getNurseryStructure()],
            'state' => ClockingInState::InProgress,
        ]));

        return count($clockIns) > 1 ? new RuntimeException(sprintf("unable to clock in several times for this agent '%s'", $clockingIn->getAgent()->getUuid())) : null;
    }

    /**
     * @return list<string>
     */
    public function transitions(): array
    {
        return [
            ClockingInTransition::InProgress->value,
            ClockingInTransition::Completed->value,
        ];
    }

    public function stateMachine(): string
    {
        return 'clocking_in';
    }
}
