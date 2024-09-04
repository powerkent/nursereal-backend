<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240830233914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add nursery structure for several nurseries';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE nursery_structure (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, start_at DATETIME DEFAULT NULL, end_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_F9102958D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE child ADD nursery_structure_id INT DEFAULT NULL, CHANGE firstname firstname VARCHAR(255) NOT NULL, CHANGE lastname lastname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B354295D1F354E FOREIGN KEY (nursery_structure_id) REFERENCES nursery_structure (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_22B354295D1F354E ON child (nursery_structure_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE child DROP FOREIGN KEY FK_22B354295D1F354E');
        $this->addSql('DROP TABLE nursery_structure');
        $this->addSql('DROP INDEX UNIQ_22B354295D1F354E ON child');
        $this->addSql('ALTER TABLE child DROP nursery_structure_id, CHANGE firstname firstname TEXT NOT NULL, CHANGE lastname lastname TEXT NOT NULL');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
