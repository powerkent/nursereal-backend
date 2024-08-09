<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240805195933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Refactoring of tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE treatment DROP FOREIGN KEY FK_98013C31AABCA765');
        $this->addSql('CREATE TABLE dosage (id INT AUTO_INCREMENT NOT NULL, treatment_id INT NOT NULL, dose VARCHAR(255) NOT NULL, dosing_date DATETIME DEFAULT NULL, INDEX IDX_1E3ECAA1471C0366 (treatment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dosage ADD CONSTRAINT FK_1E3ECAA1471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id)');
        $this->addSql('ALTER TABLE dosing DROP FOREIGN KEY FK_2FE1417CAABCA765');
        $this->addSql('DROP TABLE drug');
        $this->addSql('DROP TABLE dosing');
        $this->addSql('DROP INDEX UNIQ_98013C31AABCA765 ON treatment');
        $this->addSql('ALTER TABLE treatment DROP drug_id');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE drug (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE dosing (id INT AUTO_INCREMENT NOT NULL, drug_id INT NOT NULL, dose VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, drug_date DATETIME DEFAULT NULL, INDEX IDX_2FE1417CAABCA765 (drug_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE dosing ADD CONSTRAINT FK_2FE1417CAABCA765 FOREIGN KEY (drug_id) REFERENCES drug (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE dosage DROP FOREIGN KEY FK_1E3ECAA1471C0366');
        $this->addSql('DROP TABLE dosage');
        $this->addSql('ALTER TABLE treatment ADD drug_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE treatment ADD CONSTRAINT FK_98013C31AABCA765 FOREIGN KEY (drug_id) REFERENCES drug (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98013C31AABCA765 ON treatment (drug_id)');
    }
}
