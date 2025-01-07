<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250107004806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add coordinates for nursery structures';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE nursery_structure ADD latitude DOUBLE PRECISION DEFAULT NULL, ADD longitude DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE nursery_structure DROP latitude, DROP longitude');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
