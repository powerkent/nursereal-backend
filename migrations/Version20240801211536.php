<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240801211536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'remove of treatments for children who have IRP';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE irp_treatment DROP FOREIGN KEY FK_86562EF6471C0366');
        $this->addSql('ALTER TABLE irp_treatment DROP FOREIGN KEY FK_86562EF6EF14F020');
        $this->addSql('DROP TABLE irp_treatment');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE irp_treatment (irp_id INT NOT NULL, treatment_id INT NOT NULL, INDEX IDX_86562EF6471C0366 (treatment_id), INDEX IDX_86562EF6EF14F020 (irp_id), PRIMARY KEY(irp_id, treatment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE irp_treatment ADD CONSTRAINT FK_86562EF6471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE irp_treatment ADD CONSTRAINT FK_86562EF6EF14F020 FOREIGN KEY (irp_id) REFERENCES irp (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
