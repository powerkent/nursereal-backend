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
     * @param Action $action
     */
    public function getMarking(object $action): Marking
    {
        $marking = new Marking();

        if (null !== $state = $action->getState()) {
            $marking->mark($state->value);
        }

        return $marking;
    }

    /**
     * @param Action       $action
     * @param array<mixed> $context
     */
    public function setMarking(object $action, Marking $marking, array $context = []): void
    {
        /**
         * @var array<string, int>
         */
        $places = $marking->getPlaces();

        if (null === $state = array_key_first($places)) {
            throw new RuntimeException("Action's marking doesn't have any place.");
        }

        $action->setState(ActionState::from($state));
    }
}
