<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240801205439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add IRP tables and add fields on irp_treatment, action, activity, child and customer tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE irp (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE irp_treatment (irp_id INT NOT NULL, treatment_id INT NOT NULL, INDEX IDX_86562EF6EF14F020 (irp_id), INDEX IDX_86562EF6471C0366 (treatment_id), PRIMARY KEY(irp_id, treatment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE irp_treatment ADD CONSTRAINT FK_86562EF6EF14F020 FOREIGN KEY (irp_id) REFERENCES irp (id)');
        $this->addSql('ALTER TABLE irp_treatment ADD CONSTRAINT FK_86562EF6471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id)');
        $this->addSql('ALTER TABLE action CHANGE action_date created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE activity ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE child ADD irp INT DEFAULT NULL, ADD birthday DATETIME NOT NULL, ADD created_at DATETIME NOT NULL, CHANGE firstname firstname TEXT NOT NULL, CHANGE lastname lastname TEXT NOT NULL');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B35429F54B43F5 FOREIGN KEY (irp) REFERENCES irp (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_22B35429F54B43F5 ON child (irp)');
        $this->addSql('ALTER TABLE customer ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE treatment ADD temperature DOUBLE PRECISION DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE child DROP FOREIGN KEY FK_22B35429F54B43F5');
        $this->addSql('ALTER TABLE irp_treatment DROP FOREIGN KEY FK_86562EF6EF14F020');
        $this->addSql('ALTER TABLE irp_treatment DROP FOREIGN KEY FK_86562EF6471C0366');
        $this->addSql('DROP TABLE irp');
        $this->addSql('DROP TABLE irp_treatment');
        $this->addSql('DROP INDEX UNIQ_22B35429F54B43F5 ON child');
        $this->addSql('ALTER TABLE child DROP irp, DROP birthday, DROP created_at, CHANGE firstname firstname TEXT DEFAULT NULL, CHANGE lastname lastname TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE treatment DROP temperature, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE action CHANGE created_at action_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE activity DROP created_at');
        $this->addSql('ALTER TABLE customer DROP created_at');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
