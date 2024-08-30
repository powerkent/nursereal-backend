<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240803094549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Changes in the relationship between child and treatment models. Added a required phone number field to the customer table. The fields firstname and lastname are required, and the email becomes optional in the customer table. The description field becomes mandatory in the treatment table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE child_treatment DROP FOREIGN KEY FK_49305CBD471C0366');
        $this->addSql('ALTER TABLE child_treatment DROP FOREIGN KEY FK_49305CBDDD62C21B');
        $this->addSql('DROP TABLE child_treatment');
        $this->addSql('ALTER TABLE customer ADD phone_number INT NOT NULL, CHANGE firstname firstname TEXT NOT NULL, CHANGE lastname lastname TEXT NOT NULL, CHANGE email email TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE treatment ADD child_id INT NOT NULL, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE treatment ADD CONSTRAINT FK_98013C31DD62C21B FOREIGN KEY (child_id) REFERENCES treatment (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_98013C31DD62C21B ON treatment (child_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE child_treatment (child_id INT NOT NULL, treatment_id INT NOT NULL, INDEX IDX_49305CBD471C0366 (treatment_id), INDEX IDX_49305CBDDD62C21B (child_id), PRIMARY KEY(child_id, treatment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE child_treatment ADD CONSTRAINT FK_49305CBD471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE child_treatment ADD CONSTRAINT FK_49305CBDDD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE customer DROP phone_number, CHANGE firstname firstname TEXT DEFAULT NULL, CHANGE lastname lastname TEXT DEFAULT NULL, CHANGE email email TEXT NOT NULL');
        $this->addSql('ALTER TABLE treatment DROP FOREIGN KEY FK_98013C31DD62C21B');
        $this->addSql('DROP INDEX IDX_98013C31DD62C21B ON treatment');
        $this->addSql('ALTER TABLE treatment DROP child_id, CHANGE description description VARCHAR(255) DEFAULT NULL');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
