<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241008153914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clothing_item ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE clothing_item ADD CONSTRAINT FK_CFE0A4E9A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_CFE0A4E9A76ED395 ON clothing_item (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clothing_item DROP FOREIGN KEY FK_CFE0A4E9A76ED395');
        $this->addSql('DROP INDEX IDX_CFE0A4E9A76ED395 ON clothing_item');
        $this->addSql('ALTER TABLE clothing_item DROP user_id');
    }
}
