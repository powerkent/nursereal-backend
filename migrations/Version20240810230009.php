<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240810230009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add createdAt field in activity table and change treatment_id field in dosage table nullable';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE activity ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE dosage CHANGE treatment_id treatment_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE activity DROP created_at');
        $this->addSql('ALTER TABLE dosage CHANGE treatment_id treatment_id INT NOT NULL');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
