<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Treatment;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Domain\Shared\Repository\TreatmentRepositoryInterface;

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
