<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Symfony\Workflow\MarkingStore;

use Nursery\Domain\Shared\Enum\ClockingInState;
use Nursery\Domain\Shared\Model\ClockingIn;
use Symfony\Component\Workflow\Marking;
use Symfony\Component\Workflow\MarkingStore\MarkingStoreInterface;
use RuntimeException;

final class ClockingInMarkingStore implements MarkingStoreInterface
{
    /**
     * @param ClockingIn $clockingIn
     */
    public function getMarking(object $clockingIn): Marking
    {
        $marking = new Marking();
        $marking->mark($clockingIn->getState()->value);

        return $marking;
    }

    /**
     * @param ClockingIn   $clockingIn
     * @param array<mixed> $context
     */
    public function setMarking(object $clockingIn, Marking $marking, array $context = []): void
    {
        /**
         * @var array<string, int>
         */
        $places = $marking->getPlaces();

        if (null === $state = array_key_first($places)) {
            throw new RuntimeException("Action's marking doesn't have any place.");
        }

        $clockingIn->setState(ClockingInState::from($state));
    }
}
