<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Nursery\Application\Shared\Query\Agent\FindAgentByUuidOrIdQuery;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\Avatar;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\AgentPatchInput;
use Ramsey\Uuid\Uuid;
use RuntimeException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @implements ProcessorInterface<AgentPatchInput, bool>
 */
final readonly class AgentPatchProcessor implements ProcessorInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private string $avatarUploadDir
    ) {
    }

    /**
     * @param  AgentPatchInput $data
     * @throws Exception
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): bool
    {
        /** @var ?Agent $agent */
        $agent = $this->queryBus->ask(new FindAgentByUuidOrIdQuery(uuid: $uuid = $uriVariables['uuid']));

        if (null === $agent) {
            throw new EntityNotFoundException(Agent::class, $uuid, 'uuid');
        }

        if ($data->password) {
            $hashedPassword = $this->passwordHasher->hashPassword($agent, $data->password);
            $agent->setPassword($hashedPassword);
        }

        /** @var File $avatar */
        $avatar = $data->avatar;
        if ($avatar) {
            $filename = sprintf('%s.%s', uniqid(), $avatar->guessExtension());
            try {
                $avatar->move($this->avatarUploadDir, $filename);
            } catch (FileException) {
                throw new RuntimeException('Failed to upload avatar.');
            }
            $agent->setAvatar(new Avatar(Uuid::uuid4(), $filename));
        }

        $this->entityManager->flush();

        return true;
    }
}
