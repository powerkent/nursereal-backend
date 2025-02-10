<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Family;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\Family;
use Nursery\Domain\Shared\Repository\FamilyRepositoryInterface;

final readonly class CreateFamilyCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
    ) {
    }

    public function __invoke(CreateFamilyCommand $command): Family
    {
        $family = new Family(...$command->primitives);

        return $this->familyRepository->save($family);
    }
}
