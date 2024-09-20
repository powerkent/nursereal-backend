<?php

declare(strict_types=1);

namespace Nursery\Application\Chat\Command;

use Nursery\Domain\Chat\Model\Message;
use Nursery\Domain\Chat\Repository\MessageRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;

final readonly class CreateMessageCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private MessageRepositoryInterface $messageRepository,
    ) {
    }

    public function __invoke(CreateMessageCommand $command): Message
    {
        $message = new Message(...$command->primitives);

        return $this->messageRepository->save($message);
    }
}
