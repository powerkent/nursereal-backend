<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240904130404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add nursery structure in child table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE child ADD nursery_structure_id INT DEFAULT NULL, CHANGE firstname firstname VARCHAR(320) NOT NULL, CHANGE lastname lastname VARCHAR(320) NOT NULL');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B354295D1F354E FOREIGN KEY (nursery_structure_id) REFERENCES nursery_structure (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_22B354295D1F354E ON child (nursery_structure_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE child DROP FOREIGN KEY FK_22B354295D1F354E');
        $this->addSql('DROP INDEX UNIQ_22B354295D1F354E ON child');
        $this->addSql('ALTER TABLE child DROP nursery_structure_id, CHANGE firstname firstname TEXT NOT NULL, CHANGE lastname lastname TEXT NOT NULL');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
