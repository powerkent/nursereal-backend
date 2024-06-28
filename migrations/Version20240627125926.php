<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240627125926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add child & customer tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE child (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', firstname TEXT DEFAULT NULL, lastname TEXT DEFAULT NULL, UNIQUE INDEX UNIQ_22B35429D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', firstname TEXT DEFAULT NULL, lastname TEXT DEFAULT NULL, email TEXT DEFAULT NULL, UNIQUE INDEX UNIQ_81398E09D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_child (customer_id INT NOT NULL, child_id INT NOT NULL, INDEX IDX_EC8621129395C3F3 (customer_id), INDEX IDX_EC862112DD62C21B (child_id), PRIMARY KEY(customer_id, child_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer_child ADD CONSTRAINT FK_EC8621129395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE customer_child ADD CONSTRAINT FK_EC862112DD62C21B FOREIGN KEY (child_id) REFERENCES child (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE customer_child DROP FOREIGN KEY FK_EC8621129395C3F3');
        $this->addSql('ALTER TABLE customer_child DROP FOREIGN KEY FK_EC862112DD62C21B');
        $this->addSql('DROP TABLE child');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE customer_child');
    }
}
