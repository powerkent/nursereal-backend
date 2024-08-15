<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240813111404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change field end_date by rest_end_date';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_rest CHANGE end_date rest_end_date DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_rest CHANGE rest_end_date end_date DATETIME NOT NULL');
    }
}
