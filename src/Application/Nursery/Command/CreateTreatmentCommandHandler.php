<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Nursery\Domain\Nursery\Model\Treatment;
use Nursery\Domain\Nursery\Repository\TreatmentRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;

final readonly class CreateTreatmentCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private TreatmentRepositoryInterface $treatmentRepository,
    ) {
    }

    public function __invoke(CreateTreatmentCommand $command): Treatment
    {
        $treatment = new Treatment(...$command->primitives);

        return $this->treatmentRepository->save($treatment);
    }
}
