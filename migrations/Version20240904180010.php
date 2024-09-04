<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240904180010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create nursery_structure_agent table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE nursery_structure_agent (nursery_structure_id INT NOT NULL, agent_id INT NOT NULL, INDEX IDX_6AB3A82E5D1F354E (nursery_structure_id), INDEX IDX_6AB3A82E3414710B (agent_id), PRIMARY KEY(nursery_structure_id, agent_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nursery_structure_agent ADD CONSTRAINT FK_6AB3A82E5D1F354E FOREIGN KEY (nursery_structure_id) REFERENCES nursery_structure (id)');
        $this->addSql('ALTER TABLE nursery_structure_agent ADD CONSTRAINT FK_6AB3A82E3414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D5D1F354E');
        $this->addSql('DROP INDEX IDX_268B9C9D5D1F354E ON agent');
        $this->addSql('ALTER TABLE agent DROP nursery_structure_id');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE nursery_structure_agent DROP FOREIGN KEY FK_6AB3A82E5D1F354E');
        $this->addSql('ALTER TABLE nursery_structure_agent DROP FOREIGN KEY FK_6AB3A82E3414710B');
        $this->addSql('DROP TABLE nursery_structure_agent');
        $this->addSql('ALTER TABLE agent ADD nursery_structure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D5D1F354E FOREIGN KEY (nursery_structure_id) REFERENCES nursery_structure (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_268B9C9D5D1F354E ON agent (nursery_structure_id)');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
