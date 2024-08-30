<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240815184355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Removing the child_activity table for now. We will design it differently';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE child_activity DROP FOREIGN KEY FK_267374FE81C06096');
        $this->addSql('ALTER TABLE child_activity DROP FOREIGN KEY FK_267374FEDD62C21B');
        $this->addSql('DROP TABLE child_activity');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE child_activity (child_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_267374FE81C06096 (activity_id), INDEX IDX_267374FEDD62C21B (child_id), PRIMARY KEY(child_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE child_activity ADD CONSTRAINT FK_267374FE81C06096 FOREIGN KEY (activity_id) REFERENCES action_activity (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE child_activity ADD CONSTRAINT FK_267374FEDD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
