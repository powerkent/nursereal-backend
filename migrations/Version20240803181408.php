<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240803181408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Modification of the relations between the treatment and child tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE treatment DROP FOREIGN KEY FK_98013C31DD62C21B');
        $this->addSql('ALTER TABLE treatment ADD CONSTRAINT FK_98013C31DD62C21B FOREIGN KEY (child_id) REFERENCES child (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE treatment DROP FOREIGN KEY FK_98013C31DD62C21B');
        $this->addSql('ALTER TABLE treatment ADD CONSTRAINT FK_98013C31DD62C21B FOREIGN KEY (child_id) REFERENCES treatment (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
