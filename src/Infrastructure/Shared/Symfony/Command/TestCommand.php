<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Symfony\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:test:command', 'test command')]
class TestCommand extends Command
{
    private SymfonyStyle $io;

    public function __construct(
    ) {
        parent::__construct();
    }

    public function configure(): void
    {
        $this->setHelp('it is a test command');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $privateKey = file_get_contents('%kernel.project_dir%/config/jwt/private.pem');
        $publicKey = file_get_contents('%kernel.project_dir%/config/jwt/public.pem');

        if (false === $privateKey || false === $publicKey) {
            throw new \Exception('Unable to read the JWT private or public key.');
        }

        $this->io->section('Summary:');
        $this->io->info('it is ok !');

        return 0;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }
}
