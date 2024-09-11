<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240911203636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE daily_weather DROP FOREIGN KEY FK_9331029AD9835775');
        $this->addSql('DROP INDEX IDX_9331029AD9835775 ON daily_weather');
        $this->addSql('ALTER TABLE daily_weather ADD temperature INT NOT NULL, ADD humidity DOUBLE PRECISION NOT NULL, DROP temperature_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE daily_weather ADD temperature_id INT DEFAULT NULL, DROP temperature, DROP humidity');
        $this->addSql('ALTER TABLE daily_weather ADD CONSTRAINT FK_9331029AD9835775 FOREIGN KEY (temperature_id) REFERENCES temperature (id)');
        $this->addSql('CREATE INDEX IDX_9331029AD9835775 ON daily_weather (temperature_id)');
    }
}
