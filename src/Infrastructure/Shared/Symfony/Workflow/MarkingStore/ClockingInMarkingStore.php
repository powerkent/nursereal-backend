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
     * @param ClockingIn $subject
     */
    public function getMarking(object $subject): Marking
    {
        $marking = new Marking();
        $marking->mark($subject->getState()->value);

        return $marking;
    }

    /**
     * @param ClockingIn   $subject
     * @param array<int, mixed> $context
     */
    public function setMarking(object $subject, Marking $marking, array $context = []): void
    {
        /**
         * @var array<string, int> $places
         */
        $places = $marking->getPlaces();

        if (null === $state = array_key_first($places)) {
            throw new RuntimeException("Action's marking doesn't have any place.");
        }

        $subject->setState(ClockingInState::from($state));
    }
}
