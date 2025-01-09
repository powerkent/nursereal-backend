<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250109155244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add agent_schedule and shift_type tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE agent_schedule (id INT AUTO_INCREMENT NOT NULL, agent_id INT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', arrival_date_time DATETIME NOT NULL, end_of_work_date_time DATETIME NOT NULL, break_date_time DATETIME NOT NULL, end_of_break_date_time DATETIME NOT NULL, UNIQUE INDEX UNIQ_6CE9086FD17F50A6 (uuid), INDEX IDX_6CE9086F3414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shift_type (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(320) NOT NULL, arrival_time TIME NOT NULL, end_of_work_time TIME NOT NULL, break_time TIME NOT NULL, end_of_break_time TIME NOT NULL, UNIQUE INDEX UNIQ_B9E728E6D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shift_type_nursery_structure (shift_type_id INT NOT NULL, nursery_structure_id INT NOT NULL, INDEX IDX_D6CDAE8BA81DB0EA (shift_type_id), INDEX IDX_D6CDAE8B5D1F354E (nursery_structure_id), PRIMARY KEY(shift_type_id, nursery_structure_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent_schedule ADD CONSTRAINT FK_6CE9086F3414710B FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shift_type_nursery_structure ADD CONSTRAINT FK_D6CDAE8BA81DB0EA FOREIGN KEY (shift_type_id) REFERENCES shift_type (id)');
        $this->addSql('ALTER TABLE shift_type_nursery_structure ADD CONSTRAINT FK_D6CDAE8B5D1F354E FOREIGN KEY (nursery_structure_id) REFERENCES nursery_structure (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE agent_schedule DROP FOREIGN KEY FK_6CE9086F3414710B');
        $this->addSql('ALTER TABLE shift_type_nursery_structure DROP FOREIGN KEY FK_D6CDAE8BA81DB0EA');
        $this->addSql('ALTER TABLE shift_type_nursery_structure DROP FOREIGN KEY FK_D6CDAE8B5D1F354E');
        $this->addSql('DROP TABLE agent_schedule');
        $this->addSql('DROP TABLE shift_type');
        $this->addSql('DROP TABLE shift_type_nursery_structure');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
