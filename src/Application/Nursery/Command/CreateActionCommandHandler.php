<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use DateTimeImmutable;
use Exception;
use Nursery\Application\Shared\Query\FindTreatmentByUuidQuery;
use Nursery\Application\Nursery\Query\FindActivityByUuidQuery;
use Nursery\Domain\Nursery\Model\Action\Presence;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Nursery\Enum\CareType;
use Nursery\Domain\Nursery\Enum\DiaperQuality;
use Nursery\Domain\Nursery\Enum\RestQuality;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Nursery\Model\Action\Activity;
use Nursery\Domain\Nursery\Model\Action\Care;
use Nursery\Domain\Nursery\Model\Action\Diaper;
use Nursery\Domain\Nursery\Model\Action\Rest;
use Nursery\Domain\Nursery\Model\Action\Treatment as ActionTreatment;
use Nursery\Domain\Shared\Exception\TreatmentNotCorrectForChildException;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Exception\SeveralChildrenOnSameTreatmentException;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Domain\Nursery\Repository\ActionRepositoryInterface;
use function array_map;

final readonly class CreateActionCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ActionRepositoryInterface $actionRepository,
        private QueryBusInterface $queryBus,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(CreateActionCommand $command): Action
    {
        $query = $command->primitives['query'];
        $query->get('parameters'); // TODO : delete that ?
        switch (ActionType::tryFrom($query->get('action'))) {
            case ActionType::Presence:
                if ($isHere = (bool) $query->get('presence')) {
                    $command->primitives['arrivalTime'] = new DateTimeImmutable();
                    $command->primitives['isHere'] = $isHere;
                }

                $this->removeUnusedPrimitives($command->primitives);

                $action = new Presence(...$command->primitives);

                break;
            case ActionType::Diaper:
                $command->primitives['diaperQuality'] = DiaperQuality::tryFrom($query->get('diaper'));

                $this->removeUnusedPrimitives($command->primitives);

                $action = new Diaper(...$command->primitives);

                break;
            case ActionType::Rest:
                $command->primitives['restEndDate'] = $command->primitives['attributes']['rest']['restEndDate'];
                $command->primitives['restQuality'] = RestQuality::tryFrom($query->get('rest'));

                $this->removeUnusedPrimitives($command->primitives);

                $action = new Rest(...$command->primitives);

                break;
            case ActionType::Care:
                $careTypes = $query->getIterator()->getArrayCopy()['care'];
                $command->primitives['careTypes'] = array_map(fn (string $careType): CareType => CareType::from($careType), $careTypes);

                $this->removeUnusedPrimitives($command->primitives);

                $action = new Care(...$command->primitives);

                break;
            case ActionType::Activity:
                $command->primitives['activity'] = $this->queryBus->ask(new FindActivityByUuidQuery($command->primitives['attributes']['activity']));

                $this->removeUnusedPrimitives($command->primitives);

                $action = new Activity(...$command->primitives);
                break;
            case ActionType::Treatment:
                $treatmentUuid = $command->primitives['attributes']['treatment']['uuid'];
                if (1 < count($children = $command->primitives['children'])) {
                    throw new SeveralChildrenOnSameTreatmentException($treatmentUuid, 'uuid');
                }

                $treatment = $this->queryBus->ask(new FindTreatmentByUuidQuery($treatmentUuid));

                if (!$treatment instanceof Treatment) {
                    throw new EntityNotFoundException(Treatment::class, $treatmentUuid, 'uuid');
                }

                /* @phpstan-ignore-next-line */
                if ($children[0] instanceof Child && $children[0]->getId() !== $treatment->getChild()->getId()) {
                    // The treatment to be administered is not correct for the child's treatments
                    throw new TreatmentNotCorrectForChildException($treatmentUuid, 'uuid');
                }

                $command->primitives['treatment'] = $treatment;
                $command->primitives['dose'] = $command->primitives['attributes']['treatment']['dose'];
                $command->primitives['dosingTime'] = $command->primitives['attributes']['treatment']['dosingTime'];
                $command->primitives['temperature'] = $command->primitives['attributes']['treatment']['temperature'];

                $this->removeUnusedPrimitives($command->primitives);

                $action = new ActionTreatment(...$command->primitives);

                break;
            default:
                throw new Exception('Unable to create an action that does not exist');
        }

        return $this->actionRepository->save($action);
    }

    /**
     * @param array<string, mixed> $primitives
     */
    private function removeUnusedPrimitives(array &$primitives): void
    {
        unset($primitives['attributes'], $primitives['query'], $primitives['actionType']);
    }
}
