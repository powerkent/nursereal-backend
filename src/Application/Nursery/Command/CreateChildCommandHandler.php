<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Nursery\Model\IRP;
use Nursery\Domain\Nursery\Repository\ChildRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;

final readonly class CreateChildCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ChildRepositoryInterface $childRepository,
    ) {
    }

    public function __invoke(CreateChildCommand $command): Child
    {
        if (!empty($command->primitives['irp'])) {
            $command->primitives['irp'] = new IRP(...$command->primitives['irp']);
        }

        $child = new Child(...$command->primitives);

        return $this->childRepository->save($child);
    }
}
