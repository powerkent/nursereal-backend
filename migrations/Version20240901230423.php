<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240901230423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add agent table and add passwords to connect agent or customer';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE agent (id INT AUTO_INCREMENT NOT NULL, nursery_structure_id INT DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', firstname VARCHAR(320) NOT NULL, lastname VARCHAR(320) NOT NULL, email VARCHAR(320) NOT NULL, password VARCHAR(320) NOT NULL, roles JSON NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_268B9C9DD17F50A6 (uuid), UNIQUE INDEX UNIQ_268B9C9DE7927C74 (email), INDEX IDX_268B9C9D5D1F354E (nursery_structure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D5D1F354E FOREIGN KEY (nursery_structure_id) REFERENCES nursery_structure (id)');
        $this->addSql('ALTER TABLE child CHANGE firstname firstname VARCHAR(320) NOT NULL, CHANGE lastname lastname VARCHAR(320) NOT NULL');
        $this->addSql('ALTER TABLE customer ADD password VARCHAR(320) NOT NULL, ADD roles JSON NOT NULL, ADD updated_at DATETIME DEFAULT NULL, CHANGE firstname firstname VARCHAR(320) NOT NULL, CHANGE lastname lastname VARCHAR(320) NOT NULL, CHANGE email email VARCHAR(320) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D5D1F354E');
        $this->addSql('DROP TABLE agent');
        $this->addSql('ALTER TABLE child CHANGE firstname firstname VARCHAR(255) NOT NULL, CHANGE lastname lastname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE customer DROP password, DROP roles, DROP updated_at, CHANGE firstname firstname TEXT NOT NULL, CHANGE lastname lastname TEXT NOT NULL, CHANGE email email TEXT DEFAULT NULL');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
