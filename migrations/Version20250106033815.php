<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250106033815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add updated_at column to customers';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE customer ADD updated_at DATETIME NULL DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE customer DROP COLUMN updated_at');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
