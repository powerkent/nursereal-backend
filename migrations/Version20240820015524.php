<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240820015524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add calendar_entry and date tables to subscribe/unsubscribe children';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE calendar_entry (id INT AUTO_INCREMENT NOT NULL, child_id INT NOT NULL, date_id INT NOT NULL, INDEX IDX_47759E1EDD62C21B (child_id), INDEX IDX_47759E1EB897366B (date_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE date (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calendar_entry ADD CONSTRAINT FK_47759E1EDD62C21B FOREIGN KEY (child_id) REFERENCES child (id)');
        $this->addSql('ALTER TABLE calendar_entry ADD CONSTRAINT FK_47759E1EB897366B FOREIGN KEY (date_id) REFERENCES date (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE calendar_entry DROP FOREIGN KEY FK_47759E1EDD62C21B');
        $this->addSql('ALTER TABLE calendar_entry DROP FOREIGN KEY FK_47759E1EB897366B');
        $this->addSql('DROP TABLE calendar_entry');
        $this->addSql('DROP TABLE date');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
