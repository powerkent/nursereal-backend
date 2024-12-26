<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Processor;

use DateTimeImmutable;
use Nursery\Application\Nursery\Command\UpdateActionCommand;
use Nursery\Application\Nursery\Query\FindActionByUuidQuery;
use Nursery\Application\Nursery\Query\FindActivityByUuidQuery;
use Nursery\Application\Shared\Query\FindAgentByUuidOrIdQuery;
use Nursery\Application\Shared\Query\FindChildByUuidOrIdQuery;
use Nursery\Application\Nursery\Command\CreateActionCommand;
use Nursery\Application\Shared\Query\FindConfigByUuidOrNameQuery;
use Nursery\Application\Shared\Query\FindTreatmentByUuidQuery;
use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Nursery\Model\Action\Activity;
use Nursery\Domain\Nursery\Model\Action\Care;
use Nursery\Domain\Nursery\Model\Action\Diaper;
use Nursery\Domain\Nursery\Model\Action\Lunch;
use Nursery\Domain\Nursery\Model\Action\Milk;
use Nursery\Domain\Nursery\Model\Action\Presence;
use Nursery\Domain\Nursery\Model\Action\Rest;
use Nursery\Domain\Nursery\Model\Action\Treatment as ActionTreatment;
use Nursery\Domain\Nursery\Processor\ActionProcessorInterface;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\Config;
use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Domain\Shared\Serializer\NormalizerInterface;
use Nursery\Infrastructure\Nursery\ApiPlatform\Input\ActionInput;
use Ramsey\Uuid\UuidInterface;
use RuntimeException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\InputBag;

final readonly class ActionProcessor implements ActionProcessorInterface
{
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private Security $security,
        private NormalizerInterface $normalizer,
    ) {
    }

    /**
     * @param ActionInput $data
     */
    public function process($data, UuidInterface $uuid, InputBag $query): Action
    {
        /** @var ?Action $action */
        $action = $this->queryBus->ask(new FindActionByUuidQuery($uuid));
        $isUpdate = null !== $action;

        /** @var Agent $agent */
        $agent = $this->security->getUser();
        $config = $this->queryBus->ask(new FindConfigByUuidOrNameQuery(name: Config::AGENT_LOGIN_WITH_PHONE));
        if (!$config->getValue() && $data->agentUuid) {
            $agent = $this->queryBus->ask(new FindAgentByUuidOrIdQuery(uuid: $data->agentUuid));
        }

        $primitives = [
            'uuid' => $uuid,
            'state' => $isUpdate ? $action->getState()->value : ActionState::NewAction,
            'createdAt' => $isUpdate ? $action->getCreatedAt()->format(self::DATE_FORMAT) : new DateTimeImmutable(),
            'updatedAt' => $isUpdate ? (new DateTimeImmutable())->format(self::DATE_FORMAT) : null,
            'child' => $isUpdate ? $action->getChild() : $this->queryBus->ask(new FindChildByUuidOrIdQuery(uuid: $data->childUuid)),
            'agent' => $isUpdate ? $action->getAgent() : $agent,
            'comment' => $data->comment,
        ];

        $context = [
            'object_to_populate' => $action,
            'ignored_attributes' => ['child', 'agent', 'activity'],
        ];

        switch ($data->actionType) {
            case ActionType::Activity:
                if (null === $data->activity?->uuid) {
                    throw new RuntimeException('Unable to find the activity if uuid does not exist');
                }

                $activity = $this->queryBus->ask(new FindActivityByUuidQuery($data->activity->uuid));
                $primitives['activity'] = $activity;
                if ($isUpdate) {
                    $action = $this->normalizer->denormalize($primitives, Activity::class, context: $context);
                    $action
                        ->setStartDateTime($data->activity->startDateTime)
                        ->setEndDateTime($data->activity->endDateTime);
                } else {
                    dump($primitives);
                    $action = (new Activity(...$primitives))
                        ->setStartDateTime($data->activity->startDateTime);
                }
                break;
            case ActionType::Care:
                if ($isUpdate) {
                    $action = $this->normalizer->denormalize($primitives, Care::class, context: $context);
                    $action->setTypes($data->care->careTypes);
                } else {
                    $primitives['types'] = $data->care->careTypes;
                    $action = new Care(...$primitives);
                }
                break;
            case ActionType::Diaper:
                $primitives['quality'] = $data->diaper->diaperQuality;

                $action = new Diaper(...$primitives);

                break;
            case ActionType::Lunch:
                if ($isUpdate) {
                    $primitives['quality'] = $data->lunch->lunchQuality->value;
                    $action = $this->normalizer->denormalize($primitives, Lunch::class, context: $context);
                    $action
                        ->setStartDateTime($data->lunch->startDateTime)
                        ->setEndDateTime($data->lunch->endDateTime)
                        ->setCompletedAgent($agent);
                } else {
                    $action = (new Lunch(...$primitives))
                        ->setStartDateTime($data->lunch->startDateTime);
                }

                break;
            case ActionType::Milk:
                $primitives['quantity'] = $data->milk->quantity;

                if ($isUpdate) {
                    $action = $this->normalizer->denormalize($primitives, Milk::class, context: $context);
                    $action
                        ->setStartDateTime($data->milk->startDateTime)
                        ->setEndDateTime($data->milk->endDateTime)
                        ->setCompletedAgent($agent);
                } else {
                    $action = (new Milk(...$primitives))
                        ->setStartDateTime($data->milk->startDateTime);
                }

                break;
            case ActionType::Presence:
                $primitives['isAbsent'] = $data->presence->isAbsent;

                if ($isUpdate) {
                    $action = $this->normalizer->denormalize($primitives, Presence::class, context: $context);
                    $action
                        ->setStartDateTime($data->presence->startDateTime)
                        ->setEndDateTime($data->presence->endDateTime)
                        ->setCompletedAgent($agent);
                } else {
                    $action = (new Presence(...$primitives))
                        ->setStartDateTime($data->presence->startDateTime);
                }

                break;
            case ActionType::Rest:
                if ($isUpdate) {
                    $action = $this->normalizer->denormalize($primitives, Rest::class, context: $context);
                    $action
                        ->setQuality($data->rest->restQuality)
                        ->setStartDateTime($data->rest->startDateTime)
                        ->setEndDateTime($data->rest->endDateTime)
                        ->setCompletedAgent($agent);
                } else {
                    $primitives['quality'] = $data->rest->restQuality;
                    $action = (new Rest(...$primitives))
                        ->setStartDateTime($data->rest->startDateTime);
                }

                break;
            case ActionType::Treatment:
                $treatment = $this->queryBus->ask(new FindTreatmentByUuidQuery($data->treatment->uuid));

                if (!$treatment instanceof Treatment) {
                    throw new EntityNotFoundException(Treatment::class, $data->treatment->uuid, 'uuid');
                }

                $primitives['treatment'] = $treatment;
                $primitives['dose'] = $data->treatment?->dose;
                $primitives['dosingTime'] = $data->treatment?->dosingTime;
                $primitives['temperature'] = $data->treatment?->temperature;

                if ($isUpdate) {
                    $action = $this->normalizer->denormalize($primitives, ActionTreatment::class, context: $context);
                } else {
                    $action = new ActionTreatment(...$primitives);
                }

                break;
        }

        return $isUpdate ? $this->commandBus->dispatch(new UpdateActionCommand($action)) : $this->commandBus->dispatch(new CreateActionCommand($action));
    }
}
