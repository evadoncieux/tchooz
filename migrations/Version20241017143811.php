<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017143811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE outfit DROP FOREIGN KEY FK_3202960146ABD2A0');
        $this->addSql('DROP INDEX IDX_3202960146ABD2A0 ON outfit');
        $this->addSql('ALTER TABLE outfit CHANGE sweater_id upper_layer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE outfit ADD CONSTRAINT FK_32029601D0519A43 FOREIGN KEY (upper_layer_id) REFERENCES clothing_item (id)');
        $this->addSql('CREATE INDEX IDX_32029601D0519A43 ON outfit (upper_layer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE outfit DROP FOREIGN KEY FK_32029601D0519A43');
        $this->addSql('DROP INDEX IDX_32029601D0519A43 ON outfit');
        $this->addSql('ALTER TABLE outfit CHANGE upper_layer_id sweater_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE outfit ADD CONSTRAINT FK_3202960146ABD2A0 FOREIGN KEY (sweater_id) REFERENCES clothing_item (id)');
        $this->addSql('CREATE INDEX IDX_3202960146ABD2A0 ON outfit (sweater_id)');
    }
}
