<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240803191522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add fields in irp table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE irp ADD created_at DATETIME NOT NULL, ADD start_at DATETIME NOT NULL, ADD end_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE irp DROP created_at, DROP start_at, DROP end_at');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
