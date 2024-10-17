<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017021031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suggestion_outfit DROP FOREIGN KEY FK_583603D7A41BB822');
        $this->addSql('ALTER TABLE suggestion_outfit DROP FOREIGN KEY FK_583603D7AE96E385');
        $this->addSql('DROP TABLE suggestion_outfit');
        $this->addSql('ALTER TABLE suggestion DROP FOREIGN KEY FK_DD80F31B59303820');
        $this->addSql('DROP INDEX IDX_DD80F31B59303820 ON suggestion');
        $this->addSql('ALTER TABLE suggestion DROP user_suggestions_id, DROP suggested_outfit');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE suggestion_outfit (suggestion_id INT NOT NULL, outfit_id INT NOT NULL, INDEX IDX_583603D7A41BB822 (suggestion_id), INDEX IDX_583603D7AE96E385 (outfit_id), PRIMARY KEY(suggestion_id, outfit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE suggestion_outfit ADD CONSTRAINT FK_583603D7A41BB822 FOREIGN KEY (suggestion_id) REFERENCES suggestion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE suggestion_outfit ADD CONSTRAINT FK_583603D7AE96E385 FOREIGN KEY (outfit_id) REFERENCES outfit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE suggestion ADD user_suggestions_id INT DEFAULT NULL, ADD suggested_outfit LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE suggestion ADD CONSTRAINT FK_DD80F31B59303820 FOREIGN KEY (user_suggestions_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DD80F31B59303820 ON suggestion (user_suggestions_id)');
    }
}
