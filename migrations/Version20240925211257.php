<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240925211257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clothing_item_weather_type (clothing_item_id INT NOT NULL, weather_type_id INT NOT NULL, INDEX IDX_B47B23B4AA13B545 (clothing_item_id), INDEX IDX_B47B23B461736FD8 (weather_type_id), PRIMARY KEY(clothing_item_id, weather_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE season_weather_type (season_id INT NOT NULL, weather_type_id INT NOT NULL, INDEX IDX_16CE694D4EC001D1 (season_id), INDEX IDX_16CE694D61736FD8 (weather_type_id), PRIMARY KEY(season_id, weather_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clothing_item_weather_type ADD CONSTRAINT FK_B47B23B4AA13B545 FOREIGN KEY (clothing_item_id) REFERENCES clothing_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE clothing_item_weather_type ADD CONSTRAINT FK_B47B23B461736FD8 FOREIGN KEY (weather_type_id) REFERENCES weather_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE season_weather_type ADD CONSTRAINT FK_16CE694D4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE season_weather_type ADD CONSTRAINT FK_16CE694D61736FD8 FOREIGN KEY (weather_type_id) REFERENCES weather_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE clothing_item ADD name VARCHAR(255) NOT NULL, ADD color VARCHAR(255) NOT NULL, ADD material VARCHAR(255) NOT NULL, ADD style VARCHAR(255) DEFAULT NULL, ADD occasion VARCHAR(255) DEFAULT NULL, ADD season VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clothing_item_weather_type DROP FOREIGN KEY FK_B47B23B4AA13B545');
        $this->addSql('ALTER TABLE clothing_item_weather_type DROP FOREIGN KEY FK_B47B23B461736FD8');
        $this->addSql('ALTER TABLE season_weather_type DROP FOREIGN KEY FK_16CE694D4EC001D1');
        $this->addSql('ALTER TABLE season_weather_type DROP FOREIGN KEY FK_16CE694D61736FD8');
        $this->addSql('DROP TABLE clothing_item_weather_type');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE season_weather_type');
        $this->addSql('ALTER TABLE clothing_item DROP name, DROP color, DROP material, DROP style, DROP occasion, DROP season');
    }
}
