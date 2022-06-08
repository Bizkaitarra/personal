<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608093227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answered_question (id INT AUTO_INCREMENT NOT NULL, question_id INT UNSIGNED NOT NULL, user_id INT NOT NULL, date DATETIME NOT NULL, answered_number INT DEFAULT NULL, INDEX IDX_E0F04F5A1E27F6BF (question_id), INDEX IDX_E0F04F5AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answered_question ADD CONSTRAINT FK_E0F04F5A1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE answered_question ADD CONSTRAINT FK_E0F04F5AA76ED395 FOREIGN KEY (user_id) REFERENCES cmsuser (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE answered_question');
    }
}
