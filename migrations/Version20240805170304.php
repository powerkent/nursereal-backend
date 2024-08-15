<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240805170304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add child_activity, dosing, drug tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE child_activity (child_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_267374FEDD62C21B (child_id), INDEX IDX_267374FE81C06096 (activity_id), PRIMARY KEY(child_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dosing (id INT AUTO_INCREMENT NOT NULL, drug_id INT NOT NULL, dose VARCHAR(255) NOT NULL, drug_date DATETIME DEFAULT NULL, INDEX IDX_2FE1417CAABCA765 (drug_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE drug (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE child_activity ADD CONSTRAINT FK_267374FEDD62C21B FOREIGN KEY (child_id) REFERENCES child (id)');
        $this->addSql('ALTER TABLE child_activity ADD CONSTRAINT FK_267374FE81C06096 FOREIGN KEY (activity_id) REFERENCES action_activity (id)');
        $this->addSql('ALTER TABLE dosing ADD CONSTRAINT FK_2FE1417CAABCA765 FOREIGN KEY (drug_id) REFERENCES drug (id)');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92DD62C21B');
        $this->addSql('DROP INDEX IDX_47CC8C92DD62C21B ON action');
        $this->addSql('ALTER TABLE action DROP child_id');
        $this->addSql('ALTER TABLE action_activity DROP INDEX IDX_7BA3793C81C06096, ADD UNIQUE INDEX UNIQ_7BA3793C81C06096 (activity_id)');
        $this->addSql('ALTER TABLE action_activity CHANGE activity_id activity_id INT NOT NULL');
        $this->addSql('ALTER TABLE action_care CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE quality quality VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE action_rest CHANGE end_date end_date DATETIME NOT NULL, CHANGE quality rest_quality VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE action_treatment DROP INDEX IDX_3C072F2C471C0366, ADD UNIQUE INDEX UNIQ_3C072F2C471C0366 (treatment_id)');
        $this->addSql('ALTER TABLE action_treatment CHANGE treatment_id treatment_id INT NOT NULL');
        $this->addSql('ALTER TABLE activity DROP created_at');
        $this->addSql('ALTER TABLE treatment ADD drug_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE treatment ADD CONSTRAINT FK_98013C31AABCA765 FOREIGN KEY (drug_id) REFERENCES drug (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98013C31AABCA765 ON treatment (drug_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE treatment DROP FOREIGN KEY FK_98013C31AABCA765');
        $this->addSql('ALTER TABLE child_activity DROP FOREIGN KEY FK_267374FEDD62C21B');
        $this->addSql('ALTER TABLE child_activity DROP FOREIGN KEY FK_267374FE81C06096');
        $this->addSql('ALTER TABLE dosing DROP FOREIGN KEY FK_2FE1417CAABCA765');
        $this->addSql('DROP TABLE child_activity');
        $this->addSql('DROP TABLE dosing');
        $this->addSql('DROP TABLE drug');
        $this->addSql('ALTER TABLE activity ADD created_at DATETIME NOT NULL');
        $this->addSql('DROP INDEX UNIQ_98013C31AABCA765 ON treatment');
        $this->addSql('ALTER TABLE treatment DROP drug_id');
        $this->addSql('ALTER TABLE action ADD child_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92DD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_47CC8C92DD62C21B ON action (child_id)');
        $this->addSql('ALTER TABLE action_activity DROP INDEX UNIQ_7BA3793C81C06096, ADD INDEX IDX_7BA3793C81C06096 (activity_id)');
        $this->addSql('ALTER TABLE action_activity CHANGE activity_id activity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE action_care CHANGE type type VARCHAR(255) NOT NULL, CHANGE quality quality VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE action_rest CHANGE end_date end_date DATETIME DEFAULT NULL, CHANGE rest_quality quality VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE action_treatment DROP INDEX UNIQ_3C072F2C471C0366, ADD INDEX IDX_3C072F2C471C0366 (treatment_id)');
        $this->addSql('ALTER TABLE action_treatment CHANGE treatment_id treatment_id INT DEFAULT NULL');
    }
}
