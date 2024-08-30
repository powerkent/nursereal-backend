<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240815232200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'removal of the uniqueness constraint on the treatment_id field';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_treatment DROP INDEX UNIQ_3C072F2C471C0366, ADD INDEX IDX_3C072F2C471C0366 (treatment_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_treatment DROP INDEX IDX_3C072F2C471C0366, ADD UNIQUE INDEX UNIQ_3C072F2C471C0366 (treatment_id)');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
