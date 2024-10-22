<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use DateTimeImmutable;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\IRP;
use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;

final readonly class CreateChildCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ChildRepositoryInterface $childRepository,
    ) {
    }

    public function __invoke(CreateChildCommand $command): Child
    {
        $command->primitives['avatar'] = null;
        if (!empty($command->primitives['irp'])) {
            $command->primitives['irp'] = new IRP(...$command->primitives['irp']);
        }

        $command->primitives['createdAt'] = new DateTimeImmutable();
        $command->primitives['updatedAt'] = null;

        $child = new Child(...$command->primitives);

        return $this->childRepository->save($child);
    }
}
