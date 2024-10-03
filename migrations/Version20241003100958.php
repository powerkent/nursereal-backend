<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241003100958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add and alter action tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE action_lunch (id INT NOT NULL, completed_agent_id INT DEFAULT NULL, start_date_time DATETIME NOT NULL, end_date_time DATETIME DEFAULT NULL, quality VARCHAR(255) DEFAULT NULL, INDEX IDX_6E3FC6677E8CD8A1 (completed_agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action_milk (id INT NOT NULL, completed_agent_id INT DEFAULT NULL, start_date_time DATETIME NOT NULL, end_date_time DATETIME DEFAULT NULL, quantity VARCHAR(255) DEFAULT NULL, INDEX IDX_CAC727187E8CD8A1 (completed_agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action_lunch ADD CONSTRAINT FK_6E3FC6677E8CD8A1 FOREIGN KEY (completed_agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE action_lunch ADD CONSTRAINT FK_6E3FC667BF396750 FOREIGN KEY (id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE action_milk ADD CONSTRAINT FK_CAC727187E8CD8A1 FOREIGN KEY (completed_agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE action_milk ADD CONSTRAINT FK_CAC72718BF396750 FOREIGN KEY (id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE child_action DROP FOREIGN KEY FK_2E9948CEDD62C21B');
        $this->addSql('ALTER TABLE child_action DROP FOREIGN KEY FK_2E9948CE9D32F035');
        $this->addSql('DROP TABLE child_action');
        $this->addSql('ALTER TABLE action ADD child_id INT NOT NULL, ADD agent_id INT NOT NULL, ADD state VARCHAR(255) NOT NULL, ADD action_type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92DD62C21B FOREIGN KEY (child_id) REFERENCES child (id)');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C923414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92DD62C21B ON action (child_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C923414710B ON action (agent_id)');
        $this->addSql('ALTER TABLE action_activity ADD completed_agent_id INT DEFAULT NULL, ADD start_date_time DATETIME NOT NULL, ADD end_date_time DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE action_activity ADD CONSTRAINT FK_7BA3793C7E8CD8A1 FOREIGN KEY (completed_agent_id) REFERENCES agent (id)');
        $this->addSql('CREATE INDEX IDX_7BA3793C7E8CD8A1 ON action_activity (completed_agent_id)');
        $this->addSql('ALTER TABLE action_presence ADD completed_agent_id INT DEFAULT NULL, CHANGE arrival_date_time start_date_time DATETIME NOT NULL, CHANGE is_here is_absent TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE action_presence ADD CONSTRAINT FK_BEA0B7C37E8CD8A1 FOREIGN KEY (completed_agent_id) REFERENCES agent (id)');
        $this->addSql('CREATE INDEX IDX_BEA0B7C37E8CD8A1 ON action_presence (completed_agent_id)');
        $this->addSql('ALTER TABLE action_rest ADD completed_agent_id INT DEFAULT NULL, CHANGE quality quality VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE action_rest ADD CONSTRAINT FK_8BF59ADE7E8CD8A1 FOREIGN KEY (completed_agent_id) REFERENCES agent (id)');
        $this->addSql('CREATE INDEX IDX_8BF59ADE7E8CD8A1 ON action_rest (completed_agent_id)');
        $this->addSql('ALTER TABLE chat_message RENAME INDEX fk_fab3fc16f675f31b TO IDX_FAB3FC16F675F31B');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE child_action (action_id INT NOT NULL, child_id INT NOT NULL, INDEX IDX_2E9948CE9D32F035 (action_id), INDEX IDX_2E9948CEDD62C21B (child_id), PRIMARY KEY(action_id, child_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE child_action ADD CONSTRAINT FK_2E9948CEDD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE child_action ADD CONSTRAINT FK_2E9948CE9D32F035 FOREIGN KEY (action_id) REFERENCES action (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE action_lunch DROP FOREIGN KEY FK_6E3FC6677E8CD8A1');
        $this->addSql('ALTER TABLE action_lunch DROP FOREIGN KEY FK_6E3FC667BF396750');
        $this->addSql('ALTER TABLE action_milk DROP FOREIGN KEY FK_CAC727187E8CD8A1');
        $this->addSql('ALTER TABLE action_milk DROP FOREIGN KEY FK_CAC72718BF396750');
        $this->addSql('DROP TABLE action_lunch');
        $this->addSql('DROP TABLE action_milk');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92DD62C21B');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C923414710B');
        $this->addSql('DROP INDEX IDX_47CC8C92DD62C21B ON action');
        $this->addSql('DROP INDEX IDX_47CC8C923414710B ON action');
        $this->addSql('ALTER TABLE action DROP child_id, DROP agent_id, DROP state, DROP action_type');
        $this->addSql('ALTER TABLE action_activity DROP FOREIGN KEY FK_7BA3793C7E8CD8A1');
        $this->addSql('DROP INDEX IDX_7BA3793C7E8CD8A1 ON action_activity');
        $this->addSql('ALTER TABLE action_activity DROP completed_agent_id, DROP start_date_time, DROP end_date_time');
        $this->addSql('ALTER TABLE action_presence DROP FOREIGN KEY FK_BEA0B7C37E8CD8A1');
        $this->addSql('DROP INDEX IDX_BEA0B7C37E8CD8A1 ON action_presence');
        $this->addSql('ALTER TABLE action_presence DROP completed_agent_id, CHANGE is_absent is_here TINYINT(1) NOT NULL, CHANGE start_date_time arrival_date_time DATETIME NOT NULL');
        $this->addSql('ALTER TABLE action_rest DROP FOREIGN KEY FK_8BF59ADE7E8CD8A1');
        $this->addSql('DROP INDEX IDX_8BF59ADE7E8CD8A1 ON action_rest');
        $this->addSql('ALTER TABLE action_rest DROP completed_agent_id');
        $this->addSql('ALTER TABLE chat_message RENAME INDEX idx_fab3fc16f675f31b TO FK_FAB3FC16F675F31B');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
