<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Avatar;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\Avatar;
use Nursery\Domain\Shared\Repository\AvatarRepositoryInterface;

final readonly class CreateAvatarCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AvatarRepositoryInterface $avatarRepository,
    ) {
    }

    public function __invoke(CreateAvatarCommand $command): Avatar
    {
        $avatar = new Avatar(...$command->primitives);

        return $this->avatarRepository->save($avatar);
    }
}
