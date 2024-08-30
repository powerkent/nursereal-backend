<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240818224022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add updated_at field in child table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE child ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE child DROP updated_at');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
