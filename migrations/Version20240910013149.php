<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240910013149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update nursery_structure fields';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE nursery_structure ADD opening_hour TIME NOT NULL, ADD closing_hour TIME NOT NULL, ADD opening_days JSON NOT NULL, DROP start_at');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE nursery_structure ADD start_at DATETIME DEFAULT NULL, DROP opening_hour, DROP closing_hour, DROP opening_days');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
