<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240920215250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add photo or document to S3';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE agent ADD photo VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE chat_message RENAME INDEX fk_fab3fc16f675f31b TO IDX_FAB3FC16F675F31B');
        $this->addSql('ALTER TABLE child ADD photo VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE customer ADD photo VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE irp ADD document VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE treatment ADD prescription VARCHAR(500) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE agent DROP photo');
        $this->addSql('ALTER TABLE chat_message RENAME INDEX idx_fab3fc16f675f31b TO FK_FAB3FC16F675F31B');
        $this->addSql('ALTER TABLE child DROP photo');
        $this->addSql('ALTER TABLE customer DROP photo');
        $this->addSql('ALTER TABLE irp DROP document');
        $this->addSql('ALTER TABLE treatment DROP prescription');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
