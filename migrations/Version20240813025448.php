<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240813025448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Separation between diaper and care';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE action_diaper (id INT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action_diaper ADD CONSTRAINT FK_55FBF7CBF396750 FOREIGN KEY (id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE action_care DROP quality, CHANGE type type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action_diaper DROP FOREIGN KEY FK_55FBF7CBF396750');
        $this->addSql('DROP TABLE action_diaper');
        $this->addSql('ALTER TABLE action_care ADD quality VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL');
    }
}
