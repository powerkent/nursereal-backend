<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240815192925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Recreate child_action table without action in Child entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE child_action (action_id INT NOT NULL, child_id INT NOT NULL, INDEX IDX_2E9948CE9D32F035 (action_id), INDEX IDX_2E9948CEDD62C21B (child_id), PRIMARY KEY(action_id, child_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE child_action ADD CONSTRAINT FK_2E9948CE9D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('ALTER TABLE child_action ADD CONSTRAINT FK_2E9948CEDD62C21B FOREIGN KEY (child_id) REFERENCES child (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE child_action DROP FOREIGN KEY FK_2E9948CE9D32F035');
        $this->addSql('ALTER TABLE child_action DROP FOREIGN KEY FK_2E9948CEDD62C21B');
        $this->addSql('DROP TABLE child_action');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
