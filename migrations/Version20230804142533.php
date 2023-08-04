<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230804142533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE testimony (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_523C9487A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_website (user_id INT NOT NULL, website_id INT NOT NULL, INDEX IDX_1F6243EDA76ED395 (user_id), INDEX IDX_1F6243ED18F45C82 (website_id), PRIMARY KEY(user_id, website_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE website (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, category_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, image VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date DATE NOT NULL, content_management_system VARCHAR(255) NOT NULL, activity VARCHAR(255) NOT NULL, INDEX IDX_476F5DE7A76ED395 (user_id), INDEX IDX_476F5DE712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE testimony ADD CONSTRAINT FK_523C9487A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_website ADD CONSTRAINT FK_1F6243EDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_website ADD CONSTRAINT FK_1F6243ED18F45C82 FOREIGN KEY (website_id) REFERENCES website (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE website ADD CONSTRAINT FK_476F5DE7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE website ADD CONSTRAINT FK_476F5DE712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE testimony DROP FOREIGN KEY FK_523C9487A76ED395');
        $this->addSql('ALTER TABLE user_website DROP FOREIGN KEY FK_1F6243EDA76ED395');
        $this->addSql('ALTER TABLE user_website DROP FOREIGN KEY FK_1F6243ED18F45C82');
        $this->addSql('ALTER TABLE website DROP FOREIGN KEY FK_476F5DE7A76ED395');
        $this->addSql('ALTER TABLE website DROP FOREIGN KEY FK_476F5DE712469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE testimony');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_website');
        $this->addSql('DROP TABLE website');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
