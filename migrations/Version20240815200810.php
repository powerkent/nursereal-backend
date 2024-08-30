<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240815200810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add dose and dosingTime fiels in action_treatment table + dose is now nullable';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_treatment ADD dose VARCHAR(255) DEFAULT NULL, ADD dosing_time TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE dosage CHANGE dose dose VARCHAR(255) DEFAULT NULL, CHANGE dosing_date dosing_time TIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE dosage CHANGE dose dose VARCHAR(255) NOT NULL, CHANGE dosing_time dosing_date TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE action_treatment DROP dose, DROP dosing_time');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
