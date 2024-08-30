<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240828223258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Drop calendar_entry & calendar_entry_contract_date (overkill). Managing contract dates differently';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE calendar_entry DROP FOREIGN KEY FK_47759E1EDD62C21B');
        $this->addSql('ALTER TABLE calendar_entry_contract_date DROP FOREIGN KEY FK_6D832525B0C64BA3');
        $this->addSql('ALTER TABLE calendar_entry_contract_date DROP FOREIGN KEY FK_6D832525BF54692A');
        $this->addSql('DROP TABLE calendar_entry');
        $this->addSql('DROP TABLE calendar_entry_contract_date');
        $this->addSql('ALTER TABLE contract_date ADD child_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contract_date ADD CONSTRAINT FK_C2EB7912DD62C21B FOREIGN KEY (child_id) REFERENCES child (id)');
        $this->addSql('CREATE INDEX IDX_C2EB7912DD62C21B ON contract_date (child_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE calendar_entry (id INT AUTO_INCREMENT NOT NULL, child_id INT NOT NULL, INDEX IDX_47759E1EDD62C21B (child_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE calendar_entry_contract_date (calendar_entry_id INT NOT NULL, contract_date_id INT NOT NULL, INDEX IDX_6D832525BF54692A (calendar_entry_id), INDEX IDX_6D832525B0C64BA3 (contract_date_id), PRIMARY KEY(calendar_entry_id, contract_date_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE calendar_entry ADD CONSTRAINT FK_47759E1EDD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE calendar_entry_contract_date ADD CONSTRAINT FK_6D832525B0C64BA3 FOREIGN KEY (contract_date_id) REFERENCES contract_date (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE calendar_entry_contract_date ADD CONSTRAINT FK_6D832525BF54692A FOREIGN KEY (calendar_entry_id) REFERENCES calendar_entry (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE contract_date DROP FOREIGN KEY FK_C2EB7912DD62C21B');
        $this->addSql('DROP INDEX IDX_C2EB7912DD62C21B ON contract_date');
        $this->addSql('ALTER TABLE contract_date DROP child_id');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
