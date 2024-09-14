<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240914190448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Refacto relationship between child and customer';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE child_customer (child_id INT NOT NULL, customer_id INT NOT NULL, INDEX IDX_B3EF3ADDD62C21B (child_id), INDEX IDX_B3EF3AD9395C3F3 (customer_id), PRIMARY KEY(child_id, customer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE child_customer ADD CONSTRAINT FK_B3EF3ADDD62C21B FOREIGN KEY (child_id) REFERENCES child (id)');
        $this->addSql('ALTER TABLE child_customer ADD CONSTRAINT FK_B3EF3AD9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE customer_child DROP FOREIGN KEY FK_EC862112DD62C21B');
        $this->addSql('ALTER TABLE customer_child DROP FOREIGN KEY FK_EC8621129395C3F3');
        $this->addSql('DROP TABLE customer_child');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE customer_child (customer_id INT NOT NULL, child_id INT NOT NULL, INDEX IDX_EC8621129395C3F3 (customer_id), INDEX IDX_EC862112DD62C21B (child_id), PRIMARY KEY(customer_id, child_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE customer_child ADD CONSTRAINT FK_EC862112DD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE customer_child ADD CONSTRAINT FK_EC8621129395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE child_customer DROP FOREIGN KEY FK_B3EF3ADDD62C21B');
        $this->addSql('ALTER TABLE child_customer DROP FOREIGN KEY FK_B3EF3AD9395C3F3');
        $this->addSql('DROP TABLE child_customer');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
