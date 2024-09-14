<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240913120529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Refactoring';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP INDEX `primary` ON customer_child');
        $this->addSql('ALTER TABLE customer_child ADD PRIMARY KEY (child_id, customer_id)');
        $this->addSql('ALTER TABLE dosage CHANGE treatment_id treatment_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX `PRIMARY` ON customer_child');
        $this->addSql('ALTER TABLE customer_child ADD PRIMARY KEY (customer_id, child_id)');
        $this->addSql('ALTER TABLE dosage CHANGE treatment_id treatment_id INT DEFAULT NULL');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
