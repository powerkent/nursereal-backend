<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240813201540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change of name quality to diaper_quality';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_diaper CHANGE quality diaper_quality VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_diaper CHANGE diaper_quality quality VARCHAR(255) NOT NULL');
    }
}
