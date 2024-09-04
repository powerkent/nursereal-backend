<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240905212759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Drop useless end_at field on nursery_structure table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE nursery_structure DROP end_at');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE nursery_structure ADD end_at DATETIME DEFAULT NULL');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
