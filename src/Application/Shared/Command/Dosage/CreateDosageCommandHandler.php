<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Dosage;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\Dosage;
use Nursery\Domain\Shared\Repository\DosageRepositoryInterface;

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
