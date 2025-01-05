<?php

declare(strict_types=1);

use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Enum\ActionTransition;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Shared\Enum\ClockingInState;
use Nursery\Domain\Shared\Enum\ClockingInTransition;
use Nursery\Domain\Shared\Model\ClockingIn;
use Nursery\Infrastructure\Nursery\Symfony\Workflow\MarkingStore\ActionMarkingStore;
use Nursery\Infrastructure\Shared\Symfony\Workflow\MarkingStore\ClockingInMarkingStore;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework): void {
    $action = $framework->workflows()->workflows('action');

    $action
        ->type('state_machine')
        ->supports([Action::class]);

    $action
        ->markingStore()
        ->service(ActionMarkingStore::class);

    $action->place()->name(ActionState::NewAction->value);
    $action->place()->name(ActionState::ActionInProgress->value);
    $action->place()->name(ActionState::ActionDone->value);

    $action->transition()
        ->name(ActionTransition::ActionInProgress->value)
        ->from([ActionState::NewAction->value])
        ->to([ActionState::ActionInProgress->value]);

    $action->transition()
        ->name(ActionTransition::ActionCompleted->value)
        ->from([ActionState::NewAction->value, ActionState::ActionInProgress->value, ActionState::ActionDone->value])
        ->to([ActionState::ActionDone->value]);


    $clockingIn = $framework->workflows()->workflows('clocking_in');
    $clockingIn
        ->type('state_machine')
        ->supports([ClockingIn::class]);

    $clockingIn
        ->markingStore()
        ->service(ClockingInMarkingStore::class);

    $clockingIn->place()->name(ClockingInState::InProgress->value);
    $clockingIn->place()->name(ClockingInState::Done->value);

    $clockingIn->transition()
        ->name(ClockingInTransition::Completed->value)
        ->from([ClockingInState::InProgress->value])
        ->to([ClockingInState::Done->value]);
};
