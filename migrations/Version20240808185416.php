<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240808185416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'field child_id nullable for treatment table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE treatment CHANGE child_id child_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE treatment CHANGE child_id child_id INT NOT NULL');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
