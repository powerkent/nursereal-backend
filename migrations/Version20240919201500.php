<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240919201500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add chat tables ';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE chat_channel (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat_channel_member (channel_id INT NOT NULL, member_id INT NOT NULL, INDEX IDX_98714E1B72F5A1AA (channel_id), INDEX IDX_98714E1B7597D3FE (member_id), PRIMARY KEY(channel_id, member_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat_member (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, member_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat_message (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, channel_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_FAB3FC1672F5A1AA (channel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chat_channel_member ADD CONSTRAINT FK_98714E1B72F5A1AA FOREIGN KEY (channel_id) REFERENCES chat_channel (id)');
        $this->addSql('ALTER TABLE chat_channel_member ADD CONSTRAINT FK_98714E1B7597D3FE FOREIGN KEY (member_id) REFERENCES chat_member (id)');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC16F675F31B FOREIGN KEY (author_id) REFERENCES chat_member (id)');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC1672F5A1AA FOREIGN KEY (channel_id) REFERENCES chat_channel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE chat_channel_member DROP FOREIGN KEY FK_98714E1B72F5A1AA');
        $this->addSql('ALTER TABLE chat_channel_member DROP FOREIGN KEY FK_98714E1B7597D3FE');
        $this->addSql('ALTER TABLE chat_message DROP FOREIGN KEY FK_FAB3FC16F675F31B');
        $this->addSql('ALTER TABLE chat_message DROP FOREIGN KEY FK_FAB3FC1672F5A1AA');
        $this->addSql('DROP TABLE chat_channel');
        $this->addSql('DROP TABLE chat_channel_member');
        $this->addSql('DROP TABLE chat_member');
        $this->addSql('DROP TABLE chat_message');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
