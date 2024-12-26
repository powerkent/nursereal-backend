<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ramsey\Uuid\Uuid;

final class Version20241224133724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add config table and modify agent and customer tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE config (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(320) NOT NULL, value TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_D48A2F7CD17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql(sprintf("INSERT INTO config (uuid, name, value) VALUES ('%s', '%s', %d)", Uuid::uuid4(), 'AGENT_LOGIN_WITH_PHONE', 1));
        $this->addSql('DROP INDEX UNIQ_268B9C9DE7927C74 ON agent');
        $this->addSql('ALTER TABLE agent ADD user VARCHAR(320) NOT NULL, CHANGE firstname firstname VARCHAR(320) DEFAULT NULL, CHANGE lastname lastname VARCHAR(320) DEFAULT NULL, CHANGE email email VARCHAR(320) DEFAULT NULL, CHANGE password password VARCHAR(320) DEFAULT NULL');
        $this->addSql('ALTER TABLE customer ADD user VARCHAR(320) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE config');
        $this->addSql('ALTER TABLE agent DROP user, CHANGE firstname firstname VARCHAR(320) NOT NULL, CHANGE lastname lastname VARCHAR(320) NOT NULL, CHANGE email email VARCHAR(320) NOT NULL, CHANGE password password VARCHAR(320) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_268B9C9DE7927C74 ON agent (email)');
        $this->addSql('ALTER TABLE customer DROP user');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
