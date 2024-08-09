<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240801233546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create child_treatment table and add new fields on treatment and action_treatment tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE child_treatment (child_id INT NOT NULL, treatment_id INT NOT NULL, INDEX IDX_49305CBDDD62C21B (child_id), INDEX IDX_49305CBD471C0366 (treatment_id), PRIMARY KEY(child_id, treatment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE child_treatment ADD CONSTRAINT FK_49305CBDDD62C21B FOREIGN KEY (child_id) REFERENCES child (id)');
        $this->addSql('ALTER TABLE child_treatment ADD CONSTRAINT FK_49305CBD471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id)');
        $this->addSql('ALTER TABLE action_treatment ADD temperature DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE customer CHANGE email email TEXT NOT NULL');
        $this->addSql('ALTER TABLE irp CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE treatment ADD created_at DATETIME NOT NULL, ADD start_at DATETIME NOT NULL, ADD end_at DATETIME DEFAULT NULL, DROP temperature');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE child_treatment DROP FOREIGN KEY FK_49305CBDDD62C21B');
        $this->addSql('ALTER TABLE child_treatment DROP FOREIGN KEY FK_49305CBD471C0366');
        $this->addSql('DROP TABLE child_treatment');
        $this->addSql('ALTER TABLE customer CHANGE email email TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE action_treatment DROP temperature');
        $this->addSql('ALTER TABLE irp CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE treatment ADD temperature DOUBLE PRECISION DEFAULT NULL, DROP created_at, DROP start_at, DROP end_at');
    }
}
