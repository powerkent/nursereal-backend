<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240815013041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change dosing_date in time type rather than datetime';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE dosage CHANGE dosing_date dosing_date TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE treatment CHANGE description description VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE dosage CHANGE dosing_date dosing_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE treatment CHANGE description description VARCHAR(255) NOT NULL');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
