<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Exception;
use Nursery\Application\Nursery\Query\FindTreatmentByUuidQuery;
use Nursery\Application\Shared\Query\FindActivityByUuidQuery;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Enum\ActionType;
use Nursery\Domain\Shared\Enum\CareType;
use Nursery\Domain\Shared\Enum\DiaperQuality;
use Nursery\Domain\Shared\Enum\RestQuality;
use Nursery\Domain\Shared\Model\AbstractAction;
use Nursery\Domain\Shared\Model\Action\Activity;
use Nursery\Domain\Shared\Model\Action\Care;
use Nursery\Domain\Shared\Model\Action\Diaper;
use Nursery\Domain\Shared\Model\Action\Rest;
use Nursery\Domain\Shared\Model\Action\Treatment;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Domain\Shared\Repository\AbstractActionRepositoryInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use function array_map;

final readonly class CreateActionCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AbstractActionRepositoryInterface $actionRepository,
        private QueryBusInterface $queryBus,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(CreateActionCommand $command): AbstractAction
    {
        $primitives = $command->primitives;
        /** @var ParameterBag $query */
        $query = $primitives['query'];
        $query->get('parameters');
        switch (ActionType::tryFrom($query->get('action'))) {
            case ActionType::Diaper:
                $primitives['diaperQuality'] = DiaperQuality::tryFrom($query->get('diaper'));

                $this->removeUnusedPrimitives($primitives);

                $diaper = new Diaper(...$primitives);

                return $this->actionRepository->save($diaper);
            case ActionType::Rest:
                $primitives['restEndDate'] = $primitives['attributes']['restEndDate'];
                $primitives['restQuality'] = RestQuality::tryFrom($query->get('rest'));

                $this->removeUnusedPrimitives($primitives);

                $rest = new Rest(...$primitives);

                return $this->actionRepository->save($rest);
            case ActionType::Care:
                $careTypes = $query->getIterator()->getArrayCopy()['care'];
                $primitives['careTypes'] = array_map(fn (string $careType): CareType => CareType::from($careType), $careTypes);

                $this->removeUnusedPrimitives($primitives);

                $care = new Care(...$primitives);

                return $this->actionRepository->save($care);
            case ActionType::Activity:
                $primitives['activity'] = $this->queryBus->ask(new FindActivityByUuidQuery($primitives['attributes']['activity']));

                $this->removeUnusedPrimitives($primitives);

                $activity = new Activity(...$primitives);

                return $this->actionRepository->save($activity);
            case ActionType::Treatment:
                $primitives['treatment'] = $this->queryBus->ask(new FindTreatmentByUuidQuery($primitives['attributes']['activity']));
                $primitives['temperature'] = $primitives['attributes']['temperature'];

                $this->removeUnusedPrimitives($primitives);

                $treatment = new Treatment(...$primitives);

                return $this->actionRepository->save($treatment);
            default:
                throw new Exception('Unable to create an action that does not exist');
        }
    }

    /**
     * @param array<string, mixed> $primitives
     */
    private function removeUnusedPrimitives(array &$primitives): void
    {
        unset($primitives['attributes'], $primitives['query'], $primitives['actionType']);
    }
}
