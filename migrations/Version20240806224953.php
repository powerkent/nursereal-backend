<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240806224953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Delete cascade for treatment removal';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE treatment DROP FOREIGN KEY FK_98013C31DD62C21B');
        $this->addSql('ALTER TABLE treatment ADD CONSTRAINT FK_98013C31DD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE treatment DROP FOREIGN KEY FK_98013C31DD62C21B');
        $this->addSql('ALTER TABLE treatment ADD CONSTRAINT FK_98013C31DD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
