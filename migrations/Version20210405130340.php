<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210405130340 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exam (id INT UNSIGNED AUTO_INCREMENT NOT NULL, ordering INT NOT NULL, state TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, url VARCHAR(500) NOT NULL, type VARCHAR(250) DEFAULT NULL, application INT DEFAULT 1 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT UNSIGNED AUTO_INCREMENT NOT NULL, exam_id INT UNSIGNED NOT NULL, ordering INT NOT NULL, state TINYINT(1) NOT NULL, number INT NOT NULL, question VARCHAR(255) NOT NULL, a VARCHAR(255) NOT NULL, b VARCHAR(255) NOT NULL, c VARCHAR(255) NOT NULL, d VARCHAR(255) NOT NULL, answer VARCHAR(255) NOT NULL, INDEX IDX_B6F7494E578D5E91 (exam_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E578D5E91 FOREIGN KEY (exam_id) REFERENCES exam (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E578D5E91');
        $this->addSql('DROP TABLE exam');
        $this->addSql('DROP TABLE question');
    }
}
