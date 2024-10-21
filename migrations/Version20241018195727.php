<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241018195727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add avatar';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE avatar (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', content_url TEXT NOT NULL, UNIQUE INDEX UNIQ_1677722FD17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent ADD avatar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D86383B10 FOREIGN KEY (avatar_id) REFERENCES avatar (id) ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_268B9C9D86383B10 ON agent (avatar_id)');
        $this->addSql('ALTER TABLE child ADD avatar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B3542986383B10 FOREIGN KEY (avatar_id) REFERENCES avatar (id) ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_22B3542986383B10 ON child (avatar_id)');
        $this->addSql('ALTER TABLE customer ADD avatar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E0986383B10 FOREIGN KEY (avatar_id) REFERENCES avatar (id) ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E0986383B10 ON customer (avatar_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D86383B10');
        $this->addSql('ALTER TABLE child DROP FOREIGN KEY FK_22B3542986383B10');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E0986383B10');
        $this->addSql('DROP TABLE avatar');
        $this->addSql('DROP INDEX UNIQ_268B9C9D86383B10 ON agent');
        $this->addSql('ALTER TABLE agent DROP avatar_id');
        $this->addSql('DROP INDEX UNIQ_22B3542986383B10 ON child');
        $this->addSql('ALTER TABLE child DROP avatar_id');
        $this->addSql('DROP INDEX UNIQ_81398E0986383B10 ON customer');
        $this->addSql('ALTER TABLE customer DROP avatar_id');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
