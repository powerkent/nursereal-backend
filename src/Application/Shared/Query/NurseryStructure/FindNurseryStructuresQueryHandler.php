<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\NurseryStructure;

use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\NurseryStructureRepositoryInterface;

final readonly class FindNurseryStructuresQueryHandler implements QueryHandlerInterface
{
    public function __construct(private NurseryStructureRepositoryInterface $nurseryStructureRepository)
    {
    }

    /**
     * @return list<NurseryStructure>
     */
    public function __invoke(FindNurseryStructuresQuery $query): iterable
    {
        return $this->nurseryStructureRepository->all();
    }
}
