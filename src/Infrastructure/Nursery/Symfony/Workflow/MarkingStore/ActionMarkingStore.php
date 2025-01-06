<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Symfony\MarkingStore;

use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Model\Action;
use Symfony\Component\Workflow\Marking;
use Symfony\Component\Workflow\MarkingStore\MarkingStoreInterface;
use RuntimeException;

final class ActionMarkingStore implements MarkingStoreInterface
{
    /**
     * @param Action $subject
     */
    public function getMarking(object $subject): Marking
    {
        $marking = new Marking();
<<<<<<< Updated upstream

        if (null !== $state = $subject->getState()) {
            $marking->mark($state->value);
        }
=======
        $marking->mark($subject->getState()->value);
>>>>>>> Stashed changes

        return $marking;
    }

    /**
<<<<<<< Updated upstream
     * @param Action            $subject
=======
     * @param Action       $subject
>>>>>>> Stashed changes
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

        $subject->setState(ActionState::from($state));
    }
}
