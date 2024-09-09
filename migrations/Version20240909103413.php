<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240909103413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add password and modify phone_number to BIGINT';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE customer ADD password VARCHAR(320) NOT NULL, CHANGE phone_number phone_number BIGINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE customer DROP password, CHANGE phone_number phone_number INT NOT NULL');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
