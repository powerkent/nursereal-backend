<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Action;

use Nursery\Application\Shared\Command\DeleteContractDateByIdsQuery;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Exception\MissingPropertyException;
use Nursery\Domain\Shared\Model\ContractDate;
use Nursery\Domain\Shared\Repository\ContractDateRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ContractDateDeleteAction
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private ContractDateRepositoryInterface $contractDateRepository,
    ) {
    }

    public function __invoke(Request $request): void
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['contractDateIds'])) {
            throw new MissingPropertyException(self::class, 'contractDateIds');
        }

        foreach ($data['contractDateIds'] as $contactDateId) {
            $contract = $this->contractDateRepository->search($contactDateId);

            if (null === $contract) {
                throw new EntityNotFoundException(ContractDate::class, $contactDateId, 'id');
            }

            $this->commandBus->dispatch(new DeleteContractDateByIdsQuery($contract));
        }
    }
}
