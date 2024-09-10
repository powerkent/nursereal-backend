<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240910111842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Refacto NurseryStructure, add nursery_structure_opening table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE nursery_structure_opening (id INT AUTO_INCREMENT NOT NULL, nursery_structure_id INT NOT NULL, opening_hour TIME NOT NULL, closing_hour TIME NOT NULL, opening_day VARCHAR(255) NOT NULL, INDEX IDX_E06991355D1F354E (nursery_structure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nursery_structure_opening ADD CONSTRAINT FK_E06991355D1F354E FOREIGN KEY (nursery_structure_id) REFERENCES nursery_structure (id)');
        $this->addSql('ALTER TABLE nursery_structure DROP opening_hour, DROP closing_hour, DROP opening_days');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE nursery_structure_opening DROP FOREIGN KEY FK_E06991355D1F354E');
        $this->addSql('DROP TABLE nursery_structure_opening');
        $this->addSql('ALTER TABLE nursery_structure ADD opening_hour TIME NOT NULL, ADD closing_hour TIME NOT NULL, ADD opening_days JSON NOT NULL');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
