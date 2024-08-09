<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240807065630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Delete cascade for dosage removal';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE dosage DROP FOREIGN KEY FK_1E3ECAA1471C0366');
        $this->addSql('ALTER TABLE dosage ADD CONSTRAINT FK_1E3ECAA1471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE dosage DROP FOREIGN KEY FK_1E3ECAA1471C0366');
        $this->addSql('ALTER TABLE dosage ADD CONSTRAINT FK_1E3ECAA1471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
