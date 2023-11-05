<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231103151801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE friendship (id INT AUTO_INCREMENT NOT NULL, source_user_id_id INT NOT NULL, target_user_id_id INT NOT NULL, status INT NOT NULL, create_date DATETIME NOT NULL, INDEX IDX_7234A45FE132142B (source_user_id_id), INDEX IDX_7234A45FAF6ABD9E (target_user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, source_user_id_id INT NOT NULL, target_user_id_id INT NOT NULL, message_text VARCHAR(255) NOT NULL, create_date DATETIME NOT NULL, INDEX IDX_B6BD307FE132142B (source_user_id_id), INDEX IDX_B6BD307FAF6ABD9E (target_user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, upload_date DATETIME NOT NULL, path VARCHAR(255) NOT NULL, is_profile TINYINT(1) NOT NULL, album VARCHAR(255) DEFAULT NULL, INDEX IDX_14B784189D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_comment (id INT AUTO_INCREMENT NOT NULL, post_id_id INT NOT NULL, user_id_id INT NOT NULL, INDEX IDX_A99CE55FE85F12B8 (post_id_id), INDEX IDX_A99CE55F9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_reaction (id INT AUTO_INCREMENT NOT NULL, post_id_id INT NOT NULL, user_id_id INT DEFAULT NULL, type INT NOT NULL, INDEX IDX_1B3A8E56E85F12B8 (post_id_id), INDEX IDX_1B3A8E569D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE friendship ADD CONSTRAINT FK_7234A45FE132142B FOREIGN KEY (source_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE friendship ADD CONSTRAINT FK_7234A45FAF6ABD9E FOREIGN KEY (target_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE132142B FOREIGN KEY (source_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FAF6ABD9E FOREIGN KEY (target_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784189D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post_comment ADD CONSTRAINT FK_A99CE55FE85F12B8 FOREIGN KEY (post_id_id) REFERENCES user_post (id)');
        $this->addSql('ALTER TABLE post_comment ADD CONSTRAINT FK_A99CE55F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post_reaction ADD CONSTRAINT FK_1B3A8E56E85F12B8 FOREIGN KEY (post_id_id) REFERENCES user_post (id)');
        $this->addSql('ALTER TABLE post_reaction ADD CONSTRAINT FK_1B3A8E569D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE friendship DROP FOREIGN KEY FK_7234A45FE132142B');
        $this->addSql('ALTER TABLE friendship DROP FOREIGN KEY FK_7234A45FAF6ABD9E');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE132142B');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FAF6ABD9E');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784189D86650F');
        $this->addSql('ALTER TABLE post_comment DROP FOREIGN KEY FK_A99CE55FE85F12B8');
        $this->addSql('ALTER TABLE post_comment DROP FOREIGN KEY FK_A99CE55F9D86650F');
        $this->addSql('ALTER TABLE post_reaction DROP FOREIGN KEY FK_1B3A8E56E85F12B8');
        $this->addSql('ALTER TABLE post_reaction DROP FOREIGN KEY FK_1B3A8E569D86650F');
        $this->addSql('DROP TABLE friendship');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE post_comment');
        $this->addSql('DROP TABLE post_reaction');
    }
}
