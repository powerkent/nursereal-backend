<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Repository\NurseryStructureRepositoryInterface;

final readonly class CreateNurseryStructureCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private NurseryStructureRepositoryInterface $nurseryStructureRepository,
    ) {
    }

    public function __invoke(CreateNurseryStructureCommand $command): NurseryStructure
    {
        $nurseryStructure = new NurseryStructure(...$command->primitives);

        return $this->nurseryStructureRepository->save($nurseryStructure);
    }
}
