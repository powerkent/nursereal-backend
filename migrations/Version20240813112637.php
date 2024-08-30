<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240813112637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change field type by quality';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_diaper CHANGE type quality VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_diaper CHANGE quality type VARCHAR(255) NOT NULL');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
