<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241010104333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clothing_item (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, material VARCHAR(255) NOT NULL, weather VARCHAR(255) NOT NULL, colors JSON NOT NULL COMMENT \'(DC2Type:json)\', styles JSON NOT NULL COMMENT \'(DC2Type:json)\', category VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CFE0A4E95E237E06 (name), INDEX IDX_CFE0A4E9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE current_weather (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, timestamp DATETIME NOT NULL, temperature INT NOT NULL, temp_feels DOUBLE PRECISION NOT NULL, temp_min DOUBLE PRECISION DEFAULT NULL, temp_max DOUBLE PRECISION DEFAULT NULL, wind_speed DOUBLE PRECISION NOT NULL, rain DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outfit (id INT AUTO_INCREMENT NOT NULL, coat_id INT DEFAULT NULL, bottom_id INT DEFAULT NULL, dress_id INT DEFAULT NULL, shoes_id INT DEFAULT NULL, suit_id INT DEFAULT NULL, sweater_id INT DEFAULT NULL, top_id INT DEFAULT NULL, user_id INT NOT NULL, INDEX IDX_3202960179F419D (coat_id), INDEX IDX_320296015EED6714 (bottom_id), INDEX IDX_320296014CB5A78C (dress_id), INDEX IDX_32029601B75E1D7A (shoes_id), INDEX IDX_32029601F27CB76F (suit_id), INDEX IDX_3202960146ABD2A0 (sweater_id), INDEX IDX_32029601C82CB256 (top_id), INDEX IDX_32029601A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outfit_clothing_item (outfit_id INT NOT NULL, clothing_item_id INT NOT NULL, INDEX IDX_D50A35E3AE96E385 (outfit_id), INDEX IDX_D50A35E3AA13B545 (clothing_item_id), PRIMARY KEY(outfit_id, clothing_item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suggestion (id INT AUTO_INCREMENT NOT NULL, user_suggestions_id INT DEFAULT NULL, suggested_outfit LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_DD80F31B59303820 (user_suggestions_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suggestion_outfit (suggestion_id INT NOT NULL, outfit_id INT NOT NULL, INDEX IDX_583603D7A41BB822 (suggestion_id), INDEX IDX_583603D7AE96E385 (outfit_id), PRIMARY KEY(suggestion_id, outfit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, location VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, open_weather_city_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clothing_item ADD CONSTRAINT FK_CFE0A4E9A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE outfit ADD CONSTRAINT FK_3202960179F419D FOREIGN KEY (coat_id) REFERENCES clothing_item (id)');
        $this->addSql('ALTER TABLE outfit ADD CONSTRAINT FK_320296015EED6714 FOREIGN KEY (bottom_id) REFERENCES clothing_item (id)');
        $this->addSql('ALTER TABLE outfit ADD CONSTRAINT FK_320296014CB5A78C FOREIGN KEY (dress_id) REFERENCES clothing_item (id)');
        $this->addSql('ALTER TABLE outfit ADD CONSTRAINT FK_32029601B75E1D7A FOREIGN KEY (shoes_id) REFERENCES clothing_item (id)');
        $this->addSql('ALTER TABLE outfit ADD CONSTRAINT FK_32029601F27CB76F FOREIGN KEY (suit_id) REFERENCES clothing_item (id)');
        $this->addSql('ALTER TABLE outfit ADD CONSTRAINT FK_3202960146ABD2A0 FOREIGN KEY (sweater_id) REFERENCES clothing_item (id)');
        $this->addSql('ALTER TABLE outfit ADD CONSTRAINT FK_32029601C82CB256 FOREIGN KEY (top_id) REFERENCES clothing_item (id)');
        $this->addSql('ALTER TABLE outfit ADD CONSTRAINT FK_32029601A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE outfit_clothing_item ADD CONSTRAINT FK_D50A35E3AE96E385 FOREIGN KEY (outfit_id) REFERENCES outfit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE outfit_clothing_item ADD CONSTRAINT FK_D50A35E3AA13B545 FOREIGN KEY (clothing_item_id) REFERENCES clothing_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE suggestion ADD CONSTRAINT FK_DD80F31B59303820 FOREIGN KEY (user_suggestions_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE suggestion_outfit ADD CONSTRAINT FK_583603D7A41BB822 FOREIGN KEY (suggestion_id) REFERENCES suggestion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE suggestion_outfit ADD CONSTRAINT FK_583603D7AE96E385 FOREIGN KEY (outfit_id) REFERENCES outfit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clothing_item DROP FOREIGN KEY FK_CFE0A4E9A76ED395');
        $this->addSql('ALTER TABLE outfit DROP FOREIGN KEY FK_3202960179F419D');
        $this->addSql('ALTER TABLE outfit DROP FOREIGN KEY FK_320296015EED6714');
        $this->addSql('ALTER TABLE outfit DROP FOREIGN KEY FK_320296014CB5A78C');
        $this->addSql('ALTER TABLE outfit DROP FOREIGN KEY FK_32029601B75E1D7A');
        $this->addSql('ALTER TABLE outfit DROP FOREIGN KEY FK_32029601F27CB76F');
        $this->addSql('ALTER TABLE outfit DROP FOREIGN KEY FK_3202960146ABD2A0');
        $this->addSql('ALTER TABLE outfit DROP FOREIGN KEY FK_32029601C82CB256');
        $this->addSql('ALTER TABLE outfit DROP FOREIGN KEY FK_32029601A76ED395');
        $this->addSql('ALTER TABLE outfit_clothing_item DROP FOREIGN KEY FK_D50A35E3AE96E385');
        $this->addSql('ALTER TABLE outfit_clothing_item DROP FOREIGN KEY FK_D50A35E3AA13B545');
        $this->addSql('ALTER TABLE suggestion DROP FOREIGN KEY FK_DD80F31B59303820');
        $this->addSql('ALTER TABLE suggestion_outfit DROP FOREIGN KEY FK_583603D7A41BB822');
        $this->addSql('ALTER TABLE suggestion_outfit DROP FOREIGN KEY FK_583603D7AE96E385');
        $this->addSql('DROP TABLE clothing_item');
        $this->addSql('DROP TABLE current_weather');
        $this->addSql('DROP TABLE outfit');
        $this->addSql('DROP TABLE outfit_clothing_item');
        $this->addSql('DROP TABLE suggestion');
        $this->addSql('DROP TABLE suggestion_outfit');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
