<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241024075308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Set start_date_time nullable';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_activity CHANGE start_date_time start_date_time DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE action_lunch CHANGE start_date_time start_date_time DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE action_milk CHANGE start_date_time start_date_time DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE action_presence CHANGE start_date_time start_date_time DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE action_rest CHANGE start_date_time start_date_time DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE avatar CHANGE content_url content_url VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_activity CHANGE start_date_time start_date_time DATETIME NOT NULL');
        $this->addSql('ALTER TABLE action_lunch CHANGE start_date_time start_date_time DATETIME NOT NULL');
        $this->addSql('ALTER TABLE action_milk CHANGE start_date_time start_date_time DATETIME NOT NULL');
        $this->addSql('ALTER TABLE action_presence CHANGE start_date_time start_date_time DATETIME NOT NULL');
        $this->addSql('ALTER TABLE action_rest CHANGE start_date_time start_date_time DATETIME NOT NULL');
        $this->addSql('ALTER TABLE avatar CHANGE content_url content_url TEXT NOT NULL');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
