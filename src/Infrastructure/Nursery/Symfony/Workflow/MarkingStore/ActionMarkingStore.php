<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Symfony\Workflow\MarkingStore;

use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Model\Action;
use RuntimeException;
use Symfony\Component\Workflow\Marking;
use Symfony\Component\Workflow\MarkingStore\MarkingStoreInterface;

final class ActionMarkingStore implements MarkingStoreInterface
{
    /**
     * @param Action $clockingIn
     */
    public function getMarking(object $clockingIn): Marking
    {
        $marking = new Marking();
        $marking->mark($clockingIn->getState()->value);

        return $marking;
    }

    /**
     * @param Action       $clockingIn
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

        $clockingIn->setState(ActionState::from($state));
    }
}
