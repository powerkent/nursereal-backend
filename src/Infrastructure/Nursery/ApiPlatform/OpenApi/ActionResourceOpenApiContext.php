<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\OpenApi;

use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Repository\AgentRepositoryInterface;
use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;
use Nursery\Domain\Shared\Repository\NurseryStructureRepositoryInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\OpenApi\OpenApiContextInterface;
use function array_map;

/**
 * @codeCoverageIgnore
 */
final readonly class ActionResourceOpenApiContext implements OpenApiContextInterface
{
    public function __construct(
        private ChildRepositoryInterface $childRepository,
        private NurseryStructureRepositoryInterface $nurseryStructureRepository,
        private AgentRepositoryInterface $agentRepository,
    ) {
    }

    public function operations(): array
    {
        $children = $this->childRepository->all();
        $childrenValues = array_map(fn (Child $c) => $c->getUuid()->toString(), $children);

        $nurseries = $this->nurseryStructureRepository->all();
        $nurseriesValues = array_map(fn (NurseryStructure $ns) => $ns->getUuid()->toString(), $nurseries);

        $agents = $this->agentRepository->all();
        $agentsValues = array_map(fn (Agent $agent) => $agent->getUuid()->toString(), $agents);

        return [
            'GET /api/actions' => [
                'parameters' => [
                    [
                        'name' => 'start_date_time',
                        'in' => 'query',
                        'required' => true,
                        'schema' => ['type' => 'string'],
                    ],
                    [
                        'name' => 'end_date_time',
                        'in' => 'query',
                        'required' => true,
                        'schema' => ['type' => 'string'],
                    ],
                    [
                        'name' => 'state',
                        'in' => 'query',
                        'schema' => ['type' => 'string', 'enum' => ActionState::values()],
                    ],
                    [
                        'name' => 'actions[]',
                        'in' => 'query',
                        'explode' => true,
                        'schema' => ['type' => 'array', 'items' => ['type' => 'string', 'enum' => ActionType::values()]],
                    ],
                    [
                        'name' => 'children[]',
                        'in' => 'query',
                        'explode' => true,
                        'schema' => ['type' => 'array', 'items' => ['type' => 'string', 'enum' => $childrenValues]],
                    ],
                    [
                        'name' => 'nursery_structures[]',
                        'in' => 'query',
                        'explode' => true,
                        'schema' => ['type' => 'array', 'items' => ['type' => 'string', 'enum' => $nurseriesValues]],
                    ],
                    [
                        'name' => 'agents[]',
                        'in' => 'query',
                        'explode' => true,
                        'schema' => ['type' => 'array', 'items' => ['type' => 'string', 'enum' => $agentsValues]],
                    ],
                ],
            ],
        ];
    }
}
