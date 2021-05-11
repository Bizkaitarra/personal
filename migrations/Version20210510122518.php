<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210510122518 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ope_due_chat_status (id INT AUTO_INCREMENT NOT NULL, telegram_user_id INT NOT NULL, current_question_id INT UNSIGNED DEFAULT NULL, UNIQUE INDEX UNIQ_766DF740FC28B263 (telegram_user_id), INDEX IDX_766DF740A0F35D66 (current_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE failedQuestions (ope_due_chat_status_id INT NOT NULL, question_id INT UNSIGNED NOT NULL, INDEX IDX_1550513E7E252219 (ope_due_chat_status_id), INDEX IDX_1550513E1E27F6BF (question_id), PRIMARY KEY(ope_due_chat_status_id, question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE correctQuestions (ope_due_chat_status_id INT NOT NULL, question_id INT UNSIGNED NOT NULL, INDEX IDX_536C46627E252219 (ope_due_chat_status_id), INDEX IDX_536C46621E27F6BF (question_id), PRIMARY KEY(ope_due_chat_status_id, question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE passedQuestions (ope_due_chat_status_id INT NOT NULL, question_id INT UNSIGNED NOT NULL, INDEX IDX_831CA8F27E252219 (ope_due_chat_status_id), INDEX IDX_831CA8F21E27F6BF (question_id), PRIMARY KEY(ope_due_chat_status_id, question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE telegram_user (id INT AUTO_INCREMENT NOT NULL, bot TINYINT(1) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, language_code VARCHAR(2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ope_due_chat_status ADD CONSTRAINT FK_766DF740FC28B263 FOREIGN KEY (telegram_user_id) REFERENCES telegram_user (id)');
        $this->addSql('ALTER TABLE ope_due_chat_status ADD CONSTRAINT FK_766DF740A0F35D66 FOREIGN KEY (current_question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE failedQuestions ADD CONSTRAINT FK_1550513E7E252219 FOREIGN KEY (ope_due_chat_status_id) REFERENCES ope_due_chat_status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE failedQuestions ADD CONSTRAINT FK_1550513E1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE correctQuestions ADD CONSTRAINT FK_536C46627E252219 FOREIGN KEY (ope_due_chat_status_id) REFERENCES ope_due_chat_status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE correctQuestions ADD CONSTRAINT FK_536C46621E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE passedQuestions ADD CONSTRAINT FK_831CA8F27E252219 FOREIGN KEY (ope_due_chat_status_id) REFERENCES ope_due_chat_status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE passedQuestions ADD CONSTRAINT FK_831CA8F21E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE failedQuestions DROP FOREIGN KEY FK_1550513E7E252219');
        $this->addSql('ALTER TABLE correctQuestions DROP FOREIGN KEY FK_536C46627E252219');
        $this->addSql('ALTER TABLE passedQuestions DROP FOREIGN KEY FK_831CA8F27E252219');
        $this->addSql('ALTER TABLE ope_due_chat_status DROP FOREIGN KEY FK_766DF740FC28B263');
        $this->addSql('DROP TABLE ope_due_chat_status');
        $this->addSql('DROP TABLE failedQuestions');
        $this->addSql('DROP TABLE correctQuestions');
        $this->addSql('DROP TABLE passedQuestions');
        $this->addSql('DROP TABLE telegram_user');
    }
}
