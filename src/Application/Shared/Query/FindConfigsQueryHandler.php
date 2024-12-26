<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query;

use Nursery\Domain\Shared\Model\Config;
use Nursery\Domain\Shared\Repository\ConfigRepositoryInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;

final readonly class FindConfigsQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ConfigRepositoryInterface $configRepository)
    {
    }

    /**
     * @return array<int, Config>
     */
    public function __invoke(FindConfigsQuery $query): iterable
    {
        return $this->configRepository->all();
    }
}
