<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Infrastructure\Shared\Doctrine\Repository\ChildRepository;

final readonly class CreateChildCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ChildRepository $childRepository,
    ) {
    }

    public function __invoke(CreateChildCommand $command): Child
    {
        $customer = new Child(...$command->primitives);

        return $this->childRepository->save($customer);
    }
}
