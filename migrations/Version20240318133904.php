<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240318133904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, name_id INT NOT NULL, article_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_D9BEC0C471179CD6 (name_id), INDEX IDX_D9BEC0C47294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C471179CD6 FOREIGN KEY (name_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C47294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE contact ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE number number VARCHAR(10) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C471179CD6');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C47294869C');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('ALTER TABLE user CHANGE number number VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE contact DROP email');
    }
}
