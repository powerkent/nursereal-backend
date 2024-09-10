<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240910150411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Drop unique nursery_structure_id on child table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE child DROP INDEX UNIQ_22B354295D1F354E, ADD INDEX IDX_22B354295D1F354E (nursery_structure_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE child DROP INDEX IDX_22B354295D1F354E, ADD UNIQUE INDEX UNIQ_22B354295D1F354E (nursery_structure_id)');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
