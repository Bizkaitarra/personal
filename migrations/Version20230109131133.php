<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109131133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exam CHANGE url url VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE question CHANGE question question VARCHAR(255) NOT NULL, CHANGE a a VARCHAR(255) NOT NULL, CHANGE b b VARCHAR(255) NOT NULL, CHANGE c c VARCHAR(255) NOT NULL, CHANGE d d VARCHAR(255) NOT NULL, CHANGE detailedAnswer detailedAnswer VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE telegram_user CHANGE id id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exam CHANGE url url VARCHAR(500) NOT NULL');
        $this->addSql('ALTER TABLE question CHANGE question question TEXT NOT NULL, CHANGE a a TEXT NOT NULL, CHANGE b b TEXT NOT NULL, CHANGE c c TEXT NOT NULL, CHANGE d d TEXT NOT NULL, CHANGE detailedAnswer detailedAnswer TEXT NOT NULL');
        $this->addSql('ALTER TABLE telegram_user CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
