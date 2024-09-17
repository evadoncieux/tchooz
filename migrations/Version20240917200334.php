<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240917200334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE daily_weather ADD title VARCHAR(255) NOT NULL, ADD description VARCHAR(255) NOT NULL, ADD temp_min DOUBLE PRECISION NOT NULL, ADD temp_max DOUBLE PRECISION NOT NULL, ADD wind_speed DOUBLE PRECISION NOT NULL, ADD sunrise TIME NOT NULL, ADD sunset TIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE daily_weather DROP title, DROP description, DROP temp_min, DROP temp_max, DROP wind_speed, DROP sunrise, DROP sunset');
    }
}
