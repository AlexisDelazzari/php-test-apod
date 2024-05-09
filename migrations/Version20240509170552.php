<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509170552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE picture_liked (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, picture_id INT DEFAULT NULL, liked_at DATETIME NOT NULL, INDEX IDX_4AC34CF4A76ED395 (user_id), INDEX IDX_4AC34CF4EE45BDBF (picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE picture_liked ADD CONSTRAINT FK_4AC34CF4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE picture_liked ADD CONSTRAINT FK_4AC34CF4EE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture_liked DROP FOREIGN KEY FK_4AC34CF4A76ED395');
        $this->addSql('ALTER TABLE picture_liked DROP FOREIGN KEY FK_4AC34CF4EE45BDBF');
        $this->addSql('DROP TABLE picture_liked');
    }
}
