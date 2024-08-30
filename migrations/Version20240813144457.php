<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240813144457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Fields renaming';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action CHANGE discr type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE action_care CHANGE type care_type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_care CHANGE care_type type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE action CHANGE type discr VARCHAR(255) NOT NULL');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
