<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240810232011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add updatedAt field';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE activity ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE activity DROP updated_at');
    }
}
