<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240828115415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add calendar_entry_contract_date to add contract dates for children';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE calendar_entry_contract_date (calendar_entry_id INT NOT NULL, contract_date_id INT NOT NULL, INDEX IDX_6D832525BF54692A (calendar_entry_id), INDEX IDX_6D832525B0C64BA3 (contract_date_id), PRIMARY KEY(calendar_entry_id, contract_date_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calendar_entry_contract_date ADD CONSTRAINT FK_6D832525BF54692A FOREIGN KEY (calendar_entry_id) REFERENCES calendar_entry (id)');
        $this->addSql('ALTER TABLE calendar_entry_contract_date ADD CONSTRAINT FK_6D832525B0C64BA3 FOREIGN KEY (contract_date_id) REFERENCES contract_date (id)');
        $this->addSql('ALTER TABLE calendar_entry DROP FOREIGN KEY FK_47759E1EB897366B');
        $this->addSql('DROP INDEX IDX_47759E1EB897366B ON calendar_entry');
        $this->addSql('ALTER TABLE calendar_entry DROP date_id');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE calendar_entry_contract_date DROP FOREIGN KEY FK_6D832525BF54692A');
        $this->addSql('ALTER TABLE calendar_entry_contract_date DROP FOREIGN KEY FK_6D832525B0C64BA3');
        $this->addSql('DROP TABLE calendar_entry_contract_date');
        $this->addSql('ALTER TABLE calendar_entry ADD date_id INT NOT NULL');
        $this->addSql('ALTER TABLE calendar_entry ADD CONSTRAINT FK_47759E1EB897366B FOREIGN KEY (date_id) REFERENCES contract_date (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_47759E1EB897366B ON calendar_entry (date_id)');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
