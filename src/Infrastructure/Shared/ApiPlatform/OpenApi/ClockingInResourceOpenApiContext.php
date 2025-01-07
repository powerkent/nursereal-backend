<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\OpenApi;

use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Repository\NurseryStructureRepositoryInterface;

/**
 * @codeCoverageIgnore
 */
final readonly class ClockingInResourceOpenApiContext implements OpenApiContextInterface
{
    public function __construct(private NurseryStructureRepositoryInterface $nurseryStructureRepository)
    {
    }

    public function operations(): array
    {
        $nurseries = $this->nurseryStructureRepository->all();
        $nurseriesValues = array_map(fn (NurseryStructure $ns) => $ns->getUuid()->toString(), $nurseries);

        return [
            'GET /api/clocking_ins' => [
                'parameters' => [
                    [
                        'name' => 'nursery_structures[]',
                        'in' => 'query',
                        'explode' => true,
                        'schema' => ['type' => 'array', 'items' => ['type' => 'string', 'enum' => $nurseriesValues]],
                    ],
                    [
                        'name' => 'start_date_time',
                        'in' => 'query',
                        'required' => true,
                        'schema' => ['type' => 'string'],
                    ],
                    [
                        'name' => 'end_date_time',
                        'in' => 'query',
                        'schema' => ['type' => 'string'],
                    ],
                ],
            ],
            'POST /api/clocking_ins' => [
                'parameters' => [
                    [
                        'name' => 'nursery_structure_uuid',
                        'in' => 'query',
                        'required' => true,
                        'schema' => ['type' => 'string'],
                    ],
                ],
            ],
            'PUT /api/clocking_ins/{uuid}' => [
                'parameters' => [
                    [
                        'name' => 'nursery_structure_uuid',
                        'in' => 'query',
                        'required' => true,
                        'schema' => ['type' => 'string'],
                    ],
                ],
            ],
        ];
    }
}
