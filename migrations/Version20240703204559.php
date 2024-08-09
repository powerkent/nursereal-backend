<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240703204559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add action, treatment and activity tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action (id INT AUTO_INCREMENT NOT NULL, child_id INT DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', action_date DATETIME NOT NULL, comment VARCHAR(255) DEFAULT NULL, discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_47CC8C92D17F50A6 (uuid), INDEX IDX_47CC8C92DD62C21B (child_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action_activity (id INT NOT NULL, activity_id INT DEFAULT NULL, INDEX IDX_7BA3793C81C06096 (activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action_care (id INT NOT NULL, type VARCHAR(255) NOT NULL, quality VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action_rest (id INT NOT NULL, end_date DATETIME DEFAULT NULL, quality VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action_treatment (id INT NOT NULL, treatment_id INT DEFAULT NULL, INDEX IDX_3C072F2C471C0366 (treatment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_AC74095AD17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE treatment (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_98013C31D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92DD62C21B FOREIGN KEY (child_id) REFERENCES child (id)');
        $this->addSql('ALTER TABLE action_activity ADD CONSTRAINT FK_7BA3793C81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE action_activity ADD CONSTRAINT FK_7BA3793CBF396750 FOREIGN KEY (id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE action_care ADD CONSTRAINT FK_17F2134BBF396750 FOREIGN KEY (id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE action_rest ADD CONSTRAINT FK_8BF59ADEBF396750 FOREIGN KEY (id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE action_treatment ADD CONSTRAINT FK_3C072F2C471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id)');
        $this->addSql('ALTER TABLE action_treatment ADD CONSTRAINT FK_3C072F2CBF396750 FOREIGN KEY (id) REFERENCES action (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92DD62C21B');
        $this->addSql('ALTER TABLE action_activity DROP FOREIGN KEY FK_7BA3793C81C06096');
        $this->addSql('ALTER TABLE action_activity DROP FOREIGN KEY FK_7BA3793CBF396750');
        $this->addSql('ALTER TABLE action_care DROP FOREIGN KEY FK_17F2134BBF396750');
        $this->addSql('ALTER TABLE action_rest DROP FOREIGN KEY FK_8BF59ADEBF396750');
        $this->addSql('ALTER TABLE action_treatment DROP FOREIGN KEY FK_3C072F2C471C0366');
        $this->addSql('ALTER TABLE action_treatment DROP FOREIGN KEY FK_3C072F2CBF396750');
        $this->addSql('DROP TABLE action');
        $this->addSql('DROP TABLE action_activity');
        $this->addSql('DROP TABLE action_care');
        $this->addSql('DROP TABLE action_rest');
        $this->addSql('DROP TABLE action_treatment');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE treatment');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
