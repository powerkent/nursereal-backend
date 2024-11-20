<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241026085424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change relationship between activity and action activity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_activity DROP INDEX UNIQ_7BA3793C81C06096, ADD INDEX IDX_7BA3793C81C06096 (activity_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_activity DROP INDEX IDX_7BA3793C81C06096, ADD UNIQUE INDEX UNIQ_7BA3793C81C06096 (activity_id)');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
