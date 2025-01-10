<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use DateTimeImmutable;
use Exception;
use Nursery\Application\Shared\Command\Agent\CreateOrUpdateAgentScheduleCommand;
use Nursery\Application\Shared\Query\Agent\FindAgentByUuidOrIdQuery;
use Nursery\Application\Shared\Query\Agent\FindAgentsByNurseryStructureQuery;
use Nursery\Application\Shared\Query\Agent\FindShiftTypeByUuidQuery;
use Nursery\Application\Shared\Query\Agent\FindShiftTypesByNurseryStructureQuery;
use Nursery\Application\Shared\Query\NurseryStructure\FindNurseryStructureByUuidQuery;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Enum\OpeningDays;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Model\NurseryStructureOpening;
use Nursery\Domain\Shared\Model\ShiftType;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\AgentScheduleInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\AgentScheduleResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\AgentScheduleResourceFactory;
use Ramsey\Uuid\Uuid;
use function in_array;

/**
 * @implements ProcessorInterface<AgentScheduleInput, AgentScheduleResource>
 */
final readonly class AgentSchedulePostProcessor implements ProcessorInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus,
        private AgentScheduleResourceFactory $agentScheduleResourceFactory,
    ) {
    }

    /**
     * @param  AgentScheduleInput $data
     * @throws Exception
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): ?AgentScheduleResource
    {

        if (
            (
                ($data->shiftRotation && !$data->nurseryStructureUuid)
                && ($data->agentUuid || null !== $data->shiftTypeUuid || null !== $data->arrivalDateTime || null !== $data->endOfWorkDateTime || null !== $data->breakDateTime || null !== $data->endOfBreakDateTime)
            ) || (
                !$data->shiftRotation && (null === $data->agentUuid || !$data->nurseryStructureUuid)
            )
        ) {
            throw new Exception('Unable to process agent rotation');
        }

        if (!$data->shiftRotation && !$data->shiftTypeUuid) {
            $primitives = [
                'uuid' => Uuid::uuid4(),
                'agent' => $this->queryBus->ask(new FindAgentByUuidOrIdQuery(uuid: $data->agentUuid)),
                'arrivalDateTime' => null !== $data->arrivalDateTime ? new DateTimeImmutable($data->arrivalDateTime) : null,
                'endOfWorkDateTime' => null !== $data->endOfWorkDateTime ? new DateTimeImmutable($data->endOfWorkDateTime) : null,
                'breakDateTime' => null !== $data->breakDateTime ? new DateTimeImmutable($data->breakDateTime) : null,
                'endOfBreakDateTime' => null !== $data->endOfBreakDateTime ? new DateTimeImmutable($data->endOfBreakDateTime) : null,
            ];
            $agentSchedule = $this->commandBus->dispatch(CreateOrUpdateAgentScheduleCommand::create($primitives));

            return $this->agentScheduleResourceFactory->fromModel($agentSchedule);
        }

        if (null === $data->nurseryStructureUuid) {
            throw new Exception('Unable to process agent schedule because there is no nursery structure uuid');
        }

        [$agent, $future, $date, $openingDays, $nurseryStructure] = $this->getNeededData($data->agentUuid, $data->nurseryStructureUuid);
        if ($data->shiftTypeUuid) {
            /** @var ShiftType $shiftType */
            $shiftType = $this->queryBus->ask(new FindShiftTypeByUuidQuery($data->shiftTypeUuid));

            do {
                if (!in_array(OpeningDays::from($date->format('l')), $openingDays, true)) {
                    $date = $date->modify('+1 day');
                    continue;
                }

                $primitives = [
                    'uuid' => Uuid::uuid4(),
                    'agent' => $agent,
                    'arrivalDateTime' => $date->setTime((int) $shiftType->getArrivalTime()->format('H'), (int) $shiftType->getArrivalTime()->format('i')),
                    'endOfWorkDateTime' => $date->setTime((int) $shiftType->getEndOfWorkTime()->format('H'), (int) $shiftType->getEndOfWorkTime()->format('i')),
                    'breakDateTime' => $date->setTime((int) $shiftType->getBreakTime()->format('H'), (int) $shiftType->getBreakTime()->format('i')),
                    'endOfBreakDateTime' => $date->setTime((int) $shiftType->getEndOfBreakTime()->format('H'), (int) $shiftType->getEndOfBreakTime()->format('i')),
                ];

                $this->commandBus->dispatch(CreateOrUpdateAgentScheduleCommand::create($primitives));

                $date = $date->modify('+1 day');

            } while ($date->format('Y-m-d') < $future->format('Y-m-d'));
        }

        if ($data->shiftRotation && null !== $nurseryStructure) {
            $shiftTypes = $this->queryBus->ask(new FindShiftTypesByNurseryStructureQuery($nurseryStructure));
            $agents = $this->queryBus->ask(new FindAgentsByNurseryStructureQuery($nurseryStructure));
            if (empty($shiftTypes) || empty($agents)) {
                throw new Exception('Unable to process agent rotation because there are no shift types or agents for nursery structure');
            }

            $agents = array_filter($agents, fn (Agent $agent) => !in_array('ROLE_MANAGER', $agent->getRoles(), true));

            do {
                if (!in_array(OpeningDays::from($date->format('l')), $openingDays, true)) {
                    $date = $date->modify('+1 day');
                    continue;
                }

                $i = 0;
                foreach ($agents as $agent) {
                    $primitives = [
                        'uuid' => Uuid::uuid4(),
                        'agent' => $agent,
                        'arrivalDateTime' => $date->setTime((int) $shiftTypes[$i]->getArrivalTime()->format('H'), (int) $shiftTypes[$i]->getArrivalTime()->format('i')),
                        'endOfWorkDateTime' => $date->setTime((int) $shiftTypes[$i]->getEndOfWorkTime()->format('H'), (int) $shiftTypes[$i]->getEndOfWorkTime()->format('i')),
                        'breakDateTime' => $date->setTime((int) $shiftTypes[$i]->getBreakTime()->format('H'), (int) $shiftTypes[$i]->getBreakTime()->format('i')),
                        'endOfBreakDateTime' => $date->setTime((int) $shiftTypes[$i]->getEndOfBreakTime()->format('H'), (int) $shiftTypes[$i]->getEndOfBreakTime()->format('i')),
                    ];

                    $this->commandBus->dispatch(CreateOrUpdateAgentScheduleCommand::create($primitives));

                    if (count($shiftTypes) - 1 <= $i) {
                        $i = 0;
                    } else {
                        ++$i;
                    }
                }

                $date = $date->modify('+1 day');

            } while ($date->format('Y-m-d') < $future->format('Y-m-d'));
        }

        return null;
    }

    /**
     * @return array<int, mixed>
     * @throws Exception
     */
    private function getNeededData(?string $agentUuid, string $nurseryStructureUuid): array
    {
        /** @var NurseryStructure $nurseryStructure */
        $nurseryStructure = $this->queryBus->ask(new FindNurseryStructureByUuidQuery($nurseryStructureUuid));
        $openings = $nurseryStructure->getOpenings();
        $agent = null !== $agentUuid ? $this->queryBus->ask(new FindAgentByUuidOrIdQuery(uuid: $agentUuid)) : null;
        $future = new DateTimeImmutable('+ 2 months');
        $date = new DateTimeImmutable();
        $openingDays = $openings->map(fn (NurseryStructureOpening $nso): OpeningDays => $nso->getOpeningDay())->toArray();

        return [$agent, $future, $date, $openingDays, $nurseryStructure];
    }
}
