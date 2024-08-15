<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240814110930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Renaming carte_type en care_types';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_care ADD care_types JSON NOT NULL, DROP care_type');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_care ADD care_type VARCHAR(255) NOT NULL, DROP care_types');
    }
}
