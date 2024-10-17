<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017143359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE outfit ADD accessory_id INT DEFAULT NULL, ADD headwear_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE outfit ADD CONSTRAINT FK_3202960127E8CC78 FOREIGN KEY (accessory_id) REFERENCES clothing_item (id)');
        $this->addSql('ALTER TABLE outfit ADD CONSTRAINT FK_3202960124756887 FOREIGN KEY (headwear_id) REFERENCES clothing_item (id)');
        $this->addSql('CREATE INDEX IDX_3202960127E8CC78 ON outfit (accessory_id)');
        $this->addSql('CREATE INDEX IDX_3202960124756887 ON outfit (headwear_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE outfit DROP FOREIGN KEY FK_3202960127E8CC78');
        $this->addSql('ALTER TABLE outfit DROP FOREIGN KEY FK_3202960124756887');
        $this->addSql('DROP INDEX IDX_3202960127E8CC78 ON outfit');
        $this->addSql('DROP INDEX IDX_3202960124756887 ON outfit');
        $this->addSql('ALTER TABLE outfit DROP accessory_id, DROP headwear_id');
    }
}
