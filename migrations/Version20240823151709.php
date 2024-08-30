<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240823151709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create action_presence table and rename date table by contract_date';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE calendar_entry DROP FOREIGN KEY FK_47759E1EB897366B');
        $this->addSql('CREATE TABLE action_presence (id INT NOT NULL, arrival_time DATETIME NOT NULL, end_time DATETIME NOT NULL, is_here TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contract_date (id INT AUTO_INCREMENT NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action_presence ADD CONSTRAINT FK_BEA0B7C3BF396750 FOREIGN KEY (id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE date');
        $this->addSql('ALTER TABLE calendar_entry ADD CONSTRAINT FK_47759E1EB897366B FOREIGN KEY (date_id) REFERENCES contract_date (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE calendar_entry DROP FOREIGN KEY FK_47759E1EB897366B');
        $this->addSql('CREATE TABLE date (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE action_presence DROP FOREIGN KEY FK_BEA0B7C3BF396750');
        $this->addSql('DROP TABLE action_presence');
        $this->addSql('DROP TABLE contract_date');
        $this->addSql('ALTER TABLE calendar_entry ADD CONSTRAINT FK_47759E1EB897366B FOREIGN KEY (date_id) REFERENCES date (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
