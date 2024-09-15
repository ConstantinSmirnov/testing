<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240915065431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE testing_answer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE testing_question_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE testing_answer (id INT NOT NULL DEFAULT nextval(\'testing_answer_id_seq\'), question_id INT DEFAULT NULL, text TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F174F0571E27F6BF ON testing_answer (question_id)');
        $this->addSql('CREATE TABLE testing_question (id INT NOT NULL DEFAULT nextval(\'testing_question_id_seq\'), text TEXT NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        // Add data into questions
        $this->addSql("INSERT INTO testing_question (text, type) VALUES ('1 + 1 =', 'IS_NOT_FUZZY_LOGIC')");
        $this->addSql("INSERT INTO testing_question (text, type) VALUES ('2 + 2 =', 'FUZZY_LOGIC')");
        $this->addSql("INSERT INTO testing_question (text, type) VALUES ('3 + 3 =', 'FUZZY_LOGIC')");
        $this->addSql("INSERT INTO testing_question (text, type) VALUES ('4 + 4 =', 'FUZZY_LOGIC')");
        $this->addSql("INSERT INTO testing_question (text, type) VALUES ('5 + 5 =', 'FUZZY_LOGIC')");
        $this->addSql("INSERT INTO testing_question (text, type) VALUES ('5 + 5 =', 'IS_NOT_FUZZY_LOGIC')");
        $this->addSql("INSERT INTO testing_question (text, type) VALUES ('6 + 6 =', 'FUZZY_LOGIC')");
        $this->addSql("INSERT INTO testing_question (text, type) VALUES ('7 + 7 =', 'IS_NOT_FUZZY_LOGIC')");
        $this->addSql("INSERT INTO testing_question (text, type) VALUES ('8 + 8 =', 'IS_NOT_FUZZY_LOGIC')");
        $this->addSql("INSERT INTO testing_question (text, type) VALUES ('9 + 9 =', 'FUZZY_LOGIC')");
        $this->addSql("INSERT INTO testing_question (text, type) VALUES ('10 + 10 =', 'IS_NOT_FUZZY_LOGIC')");

        $this->addSql('CREATE TABLE users_user (ulid VARCHAR(26) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(ulid))');
        $this->addSql('ALTER TABLE testing_answer ADD CONSTRAINT FK_F174F0571E27F6BF FOREIGN KEY (question_id) REFERENCES testing_question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        // Add data into answers
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (1, '3')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (1, '2')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (1, '0')");

        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (2, '4')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (2, '3 + 1')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (2, '10')");

        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (3, '1 + 5')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (3, '1')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (3, '6')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (3, '2 + 4')");

        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (4, '8')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (4, '4')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (4, '0')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (4, '0 + 8')");

        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (5, '6')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (5, '18')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (5, '10')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (5, '9')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (5, '0')");

        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (6, '3')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (6, '9')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (6, '0')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (6, '12')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (6, '5 + 7')");

        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (7, '5')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (7, '14')");

        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (8, '16')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (8, '12')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (8, '9')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (8, '5')");

        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (9, '18')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (9, '9')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (9, '17 + 1')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (9, '2 + 16')");

        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (10, '0')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (10, '2')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (10, '8')");
        $this->addSql("INSERT INTO testing_answer (question_id, text) VALUES (10, '20')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE testing_answer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE testing_question_id_seq CASCADE');
        $this->addSql('ALTER TABLE testing_answer DROP CONSTRAINT FK_F174F0571E27F6BF');
        $this->addSql('DROP TABLE testing_answer');
        $this->addSql('DROP TABLE testing_question');
        $this->addSql('DROP TABLE users_user');
    }
}
