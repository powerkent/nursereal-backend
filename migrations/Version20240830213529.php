<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240830213529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add more consistency to field names for action tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE action_care CHANGE care_types types JSON NOT NULL');
        $this->addSql('ALTER TABLE action_diaper CHANGE diaper_quality quality VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE action_presence ADD arrival_date_time DATETIME NOT NULL, ADD end_date_time DATETIME DEFAULT NULL, DROP arrival_time, DROP end_time');
        $this->addSql('ALTER TABLE action_rest ADD end_date_time DATETIME DEFAULT NULL, CHANGE rest_end_date start_date_time DATETIME NOT NULL, CHANGE rest_quality quality VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_diaper CHANGE quality diaper_quality VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE action_care CHANGE types care_types JSON NOT NULL');
        $this->addSql('ALTER TABLE action DROP updated_at');
        $this->addSql('ALTER TABLE action_rest DROP end_date_time, CHANGE start_date_time rest_end_date DATETIME NOT NULL, CHANGE quality rest_quality VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE action_presence ADD end_time DATETIME NOT NULL, DROP end_date_time, CHANGE arrival_date_time arrival_time DATETIME NOT NULL');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
