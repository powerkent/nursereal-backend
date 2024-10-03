<?php

declare(strict_types=1);

use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Enum\ActionTransition;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Infrastructure\Nursery\Symfony\MarkingStore\ActionMarkingStore;
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
        ->from([ActionState::NewAction->value, ActionState::ActionInProgress->value])
        ->to([ActionState::ActionDone->value]);
};
