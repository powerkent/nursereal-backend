<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250203172420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add AgeGroup, Family, TrustedPerson entities and change relationships.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(320) NOT NULL, zipcode INT NOT NULL, city VARCHAR(320) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE age_group (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, min_age INT NOT NULL, max_age INT DEFAULT NULL, adult_child_ratio INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_F88B4253D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agegroup_nurserystructure (agegroup_id INT NOT NULL, nurserystructure_id INT NOT NULL, INDEX IDX_3CBA203E446425D8 (agegroup_id), INDEX IDX_3CBA203E5775D53D (nurserystructure_id), PRIMARY KEY(agegroup_id, nurserystructure_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family (id INT AUTO_INCREMENT NOT NULL, customer_a_id INT DEFAULT NULL, customer_b_id INT DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, internal_comment VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_A5E6215BD17F50A6 (uuid), UNIQUE INDEX UNIQ_A5E6215B6F4FF72F (customer_a_id), UNIQUE INDEX UNIQ_A5E6215B7DFA58C1 (customer_b_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trusted_person (id INT AUTO_INCREMENT NOT NULL, family_id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, INDEX IDX_CE8DE883C35E566A (family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agegroup_nurserystructure ADD CONSTRAINT FK_3CBA203E446425D8 FOREIGN KEY (agegroup_id) REFERENCES age_group (id)');
        $this->addSql('ALTER TABLE agegroup_nurserystructure ADD CONSTRAINT FK_3CBA203E5775D53D FOREIGN KEY (nurserystructure_id) REFERENCES nursery_structure (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B6F4FF72F FOREIGN KEY (customer_a_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B7DFA58C1 FOREIGN KEY (customer_b_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trusted_person ADD CONSTRAINT FK_CE8DE883C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE customer_child DROP FOREIGN KEY FK_EC8621129395C3F3');
        $this->addSql('ALTER TABLE customer_child DROP FOREIGN KEY FK_EC862112DD62C21B');
        $this->addSql('DROP TABLE config');
        $this->addSql('DROP TABLE customer_child');
        $this->addSql('ALTER TABLE agent CHANGE firstname firstname VARCHAR(320) NOT NULL, CHANGE lastname lastname VARCHAR(320) NOT NULL, CHANGE email email VARCHAR(320) NOT NULL, CHANGE user user VARCHAR(320) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_1677722FD17F50A6 ON avatar');
        $this->addSql('ALTER TABLE avatar ADD type VARCHAR(255) NOT NULL, DROP uuid');
        $this->addSql('ALTER TABLE child ADD age_group_id INT DEFAULT NULL, ADD family_id INT NOT NULL, ADD gender VARCHAR(255) NOT NULL, ADD is_walking TINYINT(1) NOT NULL, ADD comment VARCHAR(255) DEFAULT NULL, ADD internal_comment VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B35429B09E220E FOREIGN KEY (age_group_id) REFERENCES age_group (id)');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B35429C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('CREATE INDEX IDX_22B35429B09E220E ON child (age_group_id)');
        $this->addSql('CREATE INDEX IDX_22B35429C35E566A ON child (family_id)');
        $this->addSql('ALTER TABLE customer ADD family_id INT NOT NULL, ADD address_id INT DEFAULT NULL, ADD income DOUBLE PRECISION DEFAULT NULL, ADD internal_comment VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(320) DEFAULT NULL, CHANGE user user VARCHAR(320) DEFAULT NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_81398E09C35E566A ON customer (family_id)');
        $this->addSql('CREATE INDEX IDX_81398E09F5B7AF75 ON customer (address_id)');
        $this->addSql('ALTER TABLE nursery_structure ADD address_id INT DEFAULT NULL, DROP address, DROP latitude, DROP longitude');
        $this->addSql('ALTER TABLE nursery_structure ADD CONSTRAINT FK_F9102958F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_F9102958F5B7AF75 ON nursery_structure (address_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09F5B7AF75');
        $this->addSql('ALTER TABLE nursery_structure DROP FOREIGN KEY FK_F9102958F5B7AF75');
        $this->addSql('ALTER TABLE child DROP FOREIGN KEY FK_22B35429B09E220E');
        $this->addSql('ALTER TABLE child DROP FOREIGN KEY FK_22B35429C35E566A');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09C35E566A');
        $this->addSql('CREATE TABLE config (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:uuid)\', name VARCHAR(320) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, value TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_D48A2F7CD17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE customer_child (customer_id INT NOT NULL, child_id INT NOT NULL, INDEX IDX_EC862112DD62C21B (child_id), INDEX IDX_EC8621129395C3F3 (customer_id), PRIMARY KEY(customer_id, child_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE customer_child ADD CONSTRAINT FK_EC8621129395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE customer_child ADD CONSTRAINT FK_EC862112DD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE agegroup_nurserystructure DROP FOREIGN KEY FK_3CBA203E446425D8');
        $this->addSql('ALTER TABLE agegroup_nurserystructure DROP FOREIGN KEY FK_3CBA203E5775D53D');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B6F4FF72F');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B7DFA58C1');
        $this->addSql('ALTER TABLE trusted_person DROP FOREIGN KEY FK_CE8DE883C35E566A');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE age_group');
        $this->addSql('DROP TABLE agegroup_nurserystructure');
        $this->addSql('DROP TABLE family');
        $this->addSql('DROP TABLE trusted_person');
        $this->addSql('ALTER TABLE agent CHANGE firstname firstname VARCHAR(320) DEFAULT NULL, CHANGE lastname lastname VARCHAR(320) DEFAULT NULL, CHANGE email email VARCHAR(320) DEFAULT NULL, CHANGE user user VARCHAR(320) NOT NULL');
        $this->addSql('ALTER TABLE avatar ADD uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', DROP type');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1677722FD17F50A6 ON avatar (uuid)');
        $this->addSql('DROP INDEX IDX_22B35429B09E220E ON child');
        $this->addSql('DROP INDEX IDX_22B35429C35E566A ON child');
        $this->addSql('ALTER TABLE child DROP age_group_id, DROP family_id, DROP gender, DROP is_walking, DROP comment, DROP internal_comment');
        $this->addSql('DROP INDEX IDX_81398E09C35E566A ON customer');
        $this->addSql('DROP INDEX IDX_81398E09F5B7AF75 ON customer');
        $this->addSql('ALTER TABLE customer DROP family_id, DROP address_id, DROP income, DROP internal_comment, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE user user VARCHAR(320) NOT NULL, CHANGE password password VARCHAR(320) NOT NULL');
        $this->addSql('DROP INDEX IDX_F9102958F5B7AF75 ON nursery_structure');
        $this->addSql('ALTER TABLE nursery_structure ADD address VARCHAR(255) NOT NULL, ADD latitude DOUBLE PRECISION DEFAULT NULL, ADD longitude DOUBLE PRECISION DEFAULT NULL, DROP address_id');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
