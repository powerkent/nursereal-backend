<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Nursery\Domain\Nursery\Model\Dosage;
use Nursery\Domain\Nursery\Repository\DosageRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;

final readonly class CreateDosageCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DosageRepositoryInterface $dosageRepository,
    ) {
    }

    public function __invoke(CreateDosageCommand $command): Dosage
    {
        $dosage = new Dosage(...$command->primitives);

        return $this->dosageRepository->save($dosage);
    }
}
