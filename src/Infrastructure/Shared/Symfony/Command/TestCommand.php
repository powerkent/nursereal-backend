<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Symfony\Command;

use DateTimeImmutable;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Repository\AgentRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand('app:test:command', 'Create aerterter default manager')]
class TestCommand extends Command
{
    private SymfonyStyle $io;

    public function __construct(
        private AgentRepositoryInterface $agentRepository,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    public function configure(): void
    {
        $this->setHelp('This erterter creates a default manager');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $agent = $this->agentRepository->search(1);

        dd($agent);
    }
}