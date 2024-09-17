<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240915075015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE testing_correct_answer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE testing_user_response_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE testing_correct_answer (id INT NOT NULL DEFAULT nextval(\'testing_correct_answer_id_seq\'), question_id INT DEFAULT NULL, combination VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_40716FD01E27F6BF ON testing_correct_answer (question_id)');
        $this->addSql('CREATE TABLE testing_user_response (id INT NOT NULL DEFAULT nextval(\'testing_user_response_id_seq\'), user_ulid VARCHAR(26) DEFAULT NULL, question_id INT DEFAULT NULL, answer_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1454CB32B8098490 ON testing_user_response (user_ulid)');
        $this->addSql('CREATE INDEX IDX_1454CB321E27F6BF ON testing_user_response (question_id)');
        $this->addSql('CREATE INDEX IDX_1454CB32AA334807 ON testing_user_response (answer_id)');
        $this->addSql('ALTER TABLE testing_correct_answer ADD CONSTRAINT FK_40716FD01E27F6BF FOREIGN KEY (question_id) REFERENCES testing_question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE testing_user_response ADD CONSTRAINT FK_1454CB32B8098490 FOREIGN KEY (user_ulid) REFERENCES users_user (ulid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE testing_user_response ADD CONSTRAINT FK_1454CB321E27F6BF FOREIGN KEY (question_id) REFERENCES testing_question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE testing_user_response ADD CONSTRAINT FK_1454CB32AA334807 FOREIGN KEY (answer_id) REFERENCES testing_answer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE testing_answer ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE testing_question ALTER id DROP DEFAULT');

        // Add correct_answers into questions
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (1, '2')");

        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (2, '4')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (2, '5')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (2, '4,5')");

        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (3, '7')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (3, '9')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (3, '10')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (3, '7,9')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (3, '7,10')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (3, '9,10')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (3, '7,9,10')");

        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (4, '11')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (4, '14')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (4, '11,14')");

        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (5, '17')");

        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (6, '23')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (6, '24')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (6, '23,24')");

        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (7, '26')");

        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (8, '27')");

        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (9, '31')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (9, '33')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (9, '34')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (9, '31,33')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (9, '31,34')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (9, '33,34')");
        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (9, '31,33,34')");

        $this->addSql("INSERT INTO testing_correct_answer (question_id, combination) VALUES (10, '38')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE testing_correct_answer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE testing_user_response_id_seq CASCADE');
        $this->addSql('ALTER TABLE testing_correct_answer DROP CONSTRAINT FK_40716FD01E27F6BF');
        $this->addSql('ALTER TABLE testing_user_response DROP CONSTRAINT FK_1454CB32B8098490');
        $this->addSql('ALTER TABLE testing_user_response DROP CONSTRAINT FK_1454CB321E27F6BF');
        $this->addSql('ALTER TABLE testing_user_response DROP CONSTRAINT FK_1454CB32AA334807');
        $this->addSql('DROP TABLE testing_correct_answer');
        $this->addSql('DROP TABLE testing_user_response');
        $this->addSql('CREATE SEQUENCE testing_question_id_seq');
        $this->addSql('SELECT setval(\'testing_question_id_seq\', (SELECT MAX(id) FROM testing_question))');
        $this->addSql('ALTER TABLE testing_question ALTER id SET DEFAULT nextval(\'testing_question_id_seq\')');
        $this->addSql('CREATE SEQUENCE testing_answer_id_seq');
        $this->addSql('SELECT setval(\'testing_answer_id_seq\', (SELECT MAX(id) FROM testing_answer))');
        $this->addSql('ALTER TABLE testing_answer ALTER id SET DEFAULT nextval(\'testing_answer_id_seq\')');
    }
}
