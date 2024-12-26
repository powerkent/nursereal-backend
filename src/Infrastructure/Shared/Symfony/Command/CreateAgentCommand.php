<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Symfony\Command;

use DateTimeImmutable;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Repository\AgentRepositoryInterface;
use Nursery\Infrastructure\Shared\Foundry\Factory\AvatarFactory;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand('app:create:agent', 'Create a default agent')]
class CreateAgentCommand extends Command
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private AgentRepositoryInterface $agentRepository,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    public function configure(): void
    {
        $this->setHelp('This command creates a default agent');
        $this->setDescription('Create an agent user with ROLE_AGENT.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $agent = new Agent(
            uuid: Uuid::uuid4(),
            avatar: AvatarFactory::createOne()->_real(),
            firstname: 'agent',
            lastname: 'agent',
            email: 'b@b.com',
            createdAt: new DateTimeImmutable(),
            updatedAt: null,
            user: 'b',
            password: null,
            nurseryStructures: [],
            roles: ['ROLE_AGENT'],
        );

        $agent->setPassword($this->passwordHasher->hashPassword($agent, 'b'));
        $this->agentRepository->save($agent);
        $output->writeln('Agent user created.');

        return Command::SUCCESS;
    }
}
