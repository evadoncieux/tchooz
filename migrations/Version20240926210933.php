<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240926210933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_NAME (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clothing_item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, material VARCHAR(255) NOT NULL, style VARCHAR(255) DEFAULT NULL, occasions JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clothing_item_category (clothing_item_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_73008811AA13B545 (clothing_item_id), INDEX IDX_7300881112469DE2 (category_id), PRIMARY KEY(clothing_item_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clothing_item_weather_type (clothing_item_id INT NOT NULL, weather_type_id INT NOT NULL, INDEX IDX_B47B23B4AA13B545 (clothing_item_id), INDEX IDX_B47B23B461736FD8 (weather_type_id), PRIMARY KEY(clothing_item_id, weather_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE daily_mood (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE daily_weather (id INT AUTO_INCREMENT NOT NULL, weather_type_id INT DEFAULT NULL, temperature INT NOT NULL, humidity DOUBLE PRECISION NOT NULL, timestamp DATETIME NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, temp_min DOUBLE PRECISION NOT NULL, temp_max DOUBLE PRECISION NOT NULL, wind_speed DOUBLE PRECISION NOT NULL, sunrise TIME NOT NULL, sunset TIME NOT NULL, INDEX IDX_9331029A61736FD8 (weather_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE factor (id INT AUTO_INCREMENT NOT NULL, daily_weather_id INT DEFAULT NULL, daily_mood_id INT DEFAULT NULL, suggestion_id INT DEFAULT NULL, weather VARCHAR(255) NOT NULL, mood VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_ED38EC00F52D9A3D (daily_weather_id), UNIQUE INDEX UNIQ_ED38EC00676802CA (daily_mood_id), INDEX IDX_ED38EC00A41BB822 (suggestion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mood (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outfit (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outfit_clothing_item (outfit_id INT NOT NULL, clothing_item_id INT NOT NULL, INDEX IDX_D50A35E3AE96E385 (outfit_id), INDEX IDX_D50A35E3AA13B545 (clothing_item_id), PRIMARY KEY(outfit_id, clothing_item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE season_weather_type (season_id INT NOT NULL, weather_type_id INT NOT NULL, INDEX IDX_16CE694D4EC001D1 (season_id), INDEX IDX_16CE694D61736FD8 (weather_type_id), PRIMARY KEY(season_id, weather_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suggestion (id INT AUTO_INCREMENT NOT NULL, user_suggestions_id INT DEFAULT NULL, suggested_outfit LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_DD80F31B59303820 (user_suggestions_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suggestion_outfit (suggestion_id INT NOT NULL, outfit_id INT NOT NULL, INDEX IDX_583603D7A41BB822 (suggestion_id), INDEX IDX_583603D7AE96E385 (outfit_id), PRIMARY KEY(suggestion_id, outfit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE temperature (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, location VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wardrobe (id INT AUTO_INCREMENT NOT NULL, wardrobe_user_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, clothing_items LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_2C80050E8E15D9A0 (wardrobe_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wardrobe_clothing_item (wardrobe_id INT NOT NULL, clothing_item_id INT NOT NULL, INDEX IDX_5A4570A4FC109F73 (wardrobe_id), INDEX IDX_5A4570A4AA13B545 (clothing_item_id), PRIMARY KEY(wardrobe_id, clothing_item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weather_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_NAME (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clothing_item_category ADD CONSTRAINT FK_73008811AA13B545 FOREIGN KEY (clothing_item_id) REFERENCES clothing_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE clothing_item_category ADD CONSTRAINT FK_7300881112469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE clothing_item_weather_type ADD CONSTRAINT FK_B47B23B4AA13B545 FOREIGN KEY (clothing_item_id) REFERENCES clothing_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE clothing_item_weather_type ADD CONSTRAINT FK_B47B23B461736FD8 FOREIGN KEY (weather_type_id) REFERENCES weather_types (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE daily_weather ADD CONSTRAINT FK_9331029A61736FD8 FOREIGN KEY (weather_type_id) REFERENCES weather_types (id)');
        $this->addSql('ALTER TABLE factor ADD CONSTRAINT FK_ED38EC00F52D9A3D FOREIGN KEY (daily_weather_id) REFERENCES daily_weather (id)');
        $this->addSql('ALTER TABLE factor ADD CONSTRAINT FK_ED38EC00676802CA FOREIGN KEY (daily_mood_id) REFERENCES daily_mood (id)');
        $this->addSql('ALTER TABLE factor ADD CONSTRAINT FK_ED38EC00A41BB822 FOREIGN KEY (suggestion_id) REFERENCES suggestion (id)');
        $this->addSql('ALTER TABLE outfit_clothing_item ADD CONSTRAINT FK_D50A35E3AE96E385 FOREIGN KEY (outfit_id) REFERENCES outfit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE outfit_clothing_item ADD CONSTRAINT FK_D50A35E3AA13B545 FOREIGN KEY (clothing_item_id) REFERENCES clothing_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE season_weather_type ADD CONSTRAINT FK_16CE694D4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE season_weather_type ADD CONSTRAINT FK_16CE694D61736FD8 FOREIGN KEY (weather_type_id) REFERENCES weather_types (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE suggestion ADD CONSTRAINT FK_DD80F31B59303820 FOREIGN KEY (user_suggestions_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE suggestion_outfit ADD CONSTRAINT FK_583603D7A41BB822 FOREIGN KEY (suggestion_id) REFERENCES suggestion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE suggestion_outfit ADD CONSTRAINT FK_583603D7AE96E385 FOREIGN KEY (outfit_id) REFERENCES outfit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wardrobe ADD CONSTRAINT FK_2C80050E8E15D9A0 FOREIGN KEY (wardrobe_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE wardrobe_clothing_item ADD CONSTRAINT FK_5A4570A4FC109F73 FOREIGN KEY (wardrobe_id) REFERENCES wardrobe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wardrobe_clothing_item ADD CONSTRAINT FK_5A4570A4AA13B545 FOREIGN KEY (clothing_item_id) REFERENCES clothing_item (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clothing_item_category DROP FOREIGN KEY FK_73008811AA13B545');
        $this->addSql('ALTER TABLE clothing_item_category DROP FOREIGN KEY FK_7300881112469DE2');
        $this->addSql('ALTER TABLE clothing_item_weather_type DROP FOREIGN KEY FK_B47B23B4AA13B545');
        $this->addSql('ALTER TABLE clothing_item_weather_type DROP FOREIGN KEY FK_B47B23B461736FD8');
        $this->addSql('ALTER TABLE daily_weather DROP FOREIGN KEY FK_9331029A61736FD8');
        $this->addSql('ALTER TABLE factor DROP FOREIGN KEY FK_ED38EC00F52D9A3D');
        $this->addSql('ALTER TABLE factor DROP FOREIGN KEY FK_ED38EC00676802CA');
        $this->addSql('ALTER TABLE factor DROP FOREIGN KEY FK_ED38EC00A41BB822');
        $this->addSql('ALTER TABLE outfit_clothing_item DROP FOREIGN KEY FK_D50A35E3AE96E385');
        $this->addSql('ALTER TABLE outfit_clothing_item DROP FOREIGN KEY FK_D50A35E3AA13B545');
        $this->addSql('ALTER TABLE season_weather_type DROP FOREIGN KEY FK_16CE694D4EC001D1');
        $this->addSql('ALTER TABLE season_weather_type DROP FOREIGN KEY FK_16CE694D61736FD8');
        $this->addSql('ALTER TABLE suggestion DROP FOREIGN KEY FK_DD80F31B59303820');
        $this->addSql('ALTER TABLE suggestion_outfit DROP FOREIGN KEY FK_583603D7A41BB822');
        $this->addSql('ALTER TABLE suggestion_outfit DROP FOREIGN KEY FK_583603D7AE96E385');
        $this->addSql('ALTER TABLE wardrobe DROP FOREIGN KEY FK_2C80050E8E15D9A0');
        $this->addSql('ALTER TABLE wardrobe_clothing_item DROP FOREIGN KEY FK_5A4570A4FC109F73');
        $this->addSql('ALTER TABLE wardrobe_clothing_item DROP FOREIGN KEY FK_5A4570A4AA13B545');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE clothing_item');
        $this->addSql('DROP TABLE clothing_item_category');
        $this->addSql('DROP TABLE clothing_item_weather_type');
        $this->addSql('DROP TABLE daily_mood');
        $this->addSql('DROP TABLE daily_weather');
        $this->addSql('DROP TABLE factor');
        $this->addSql('DROP TABLE mood');
        $this->addSql('DROP TABLE outfit');
        $this->addSql('DROP TABLE outfit_clothing_item');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE season_weather_type');
        $this->addSql('DROP TABLE suggestion');
        $this->addSql('DROP TABLE suggestion_outfit');
        $this->addSql('DROP TABLE temperature');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE wardrobe');
        $this->addSql('DROP TABLE wardrobe_clothing_item');
        $this->addSql('DROP TABLE weather_types');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
