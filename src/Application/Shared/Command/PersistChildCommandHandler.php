<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;

final readonly class PersistChildCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ChildRepositoryInterface $childRepository,
    ) {
    }

    public function __invoke(PersistChildCommand $command): Child
    {
        return $this->childRepository->update($command->child);
    }
}
