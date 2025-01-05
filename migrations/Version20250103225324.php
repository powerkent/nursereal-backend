<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250103225324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Clocking_in table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE clocking_in (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', state VARCHAR(255) NOT NULL, agent_id INT NOT NULL, nursery_structure_id INT NOT NULL, start_date_time DATETIME NOT NULL, end_date_time DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_EBB8F921D17F50A6 (uuid), INDEX IDX_EBB8F9213414710B (agent_id), INDEX IDX_EBB8F9215D1F354E (nursery_structure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clocking_in ADD CONSTRAINT FK_EBB8F9213414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE clocking_in ADD CONSTRAINT FK_EBB8F9215D1F354E FOREIGN KEY (nursery_structure_id) REFERENCES nursery_structure (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE clocking_in DROP FOREIGN KEY FK_EBB8F9213414710B');
        $this->addSql('ALTER TABLE clocking_in DROP FOREIGN KEY FK_EBB8F9215D1F354E');
        $this->addSql('DROP TABLE clocking_in');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
