<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Symfony\Command;

use DateTimeImmutable;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Repository\AgentRepositoryInterface;
use Nursery\Domain\Shared\Repository\NurseryStructureRepositoryInterface;
use Nursery\Infrastructure\Shared\Foundry\Factory\AvatarFactory;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand('app:create:manager', 'Create a default manager')]
class CreateManagerCommand extends Command
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly AgentRepositoryInterface $agentRepository,
        private readonly NurseryStructureRepositoryInterface $nurseryStructureRepository,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    public function configure(): void
    {
        $this->setHelp('This command creates a default manager');
        $this->setDescription('Create an admin user with ROLE_MANAGER.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $nurseryStructures = $this->nurseryStructureRepository->all();

        $admin = new Agent(
            uuid: Uuid::uuid4(),
            avatar: AvatarFactory::createOne()->_real(),
            firstname: 'admin',
            lastname: 'admin',
            email: 'a@a.com',
            createdAt: new DateTimeImmutable(),
            updatedAt: null,
            user: 'a',
            password: null,
            nurseryStructures: $nurseryStructures,
            roles: ['ROLE_MANAGER'],
        );

        foreach ($nurseryStructures as $nurseryStructure) {
            $nurseryStructure->addAgent($admin);
        }

        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'a'));
        $this->agentRepository->save($admin);
        $output->writeln('Admin user created.');

        return Command::SUCCESS;
    }
}
