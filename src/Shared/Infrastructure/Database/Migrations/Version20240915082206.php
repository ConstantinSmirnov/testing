<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240915082206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE testing_testing_session_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE testing_testing_session (id INT NOT NULL, user_ulid VARCHAR(26) DEFAULT NULL, is_end BOOLEAN DEFAULT false NOT NULL, question_combination VARCHAR(25) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_485F2E0AB8098490 ON testing_testing_session (user_ulid)');
        $this->addSql('ALTER TABLE testing_testing_session ADD CONSTRAINT FK_485F2E0AB8098490 FOREIGN KEY (user_ulid) REFERENCES users_user (ulid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE testing_correct_answer ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE testing_user_response DROP CONSTRAINT FK_1454CB32B8098490');
        $this->addSql('DROP INDEX uniq_1454cb32b8098490');
        $this->addSql('ALTER TABLE testing_user_response ADD testing_session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE testing_user_response ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE testing_user_response ADD CONSTRAINT FK_1454CB32BBB901EE FOREIGN KEY (testing_session_id) REFERENCES testing_testing_session (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE testing_user_response ADD CONSTRAINT FK_1454CB32B8098490 FOREIGN KEY (user_ulid) REFERENCES users_user (ulid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1454CB32B8098490 ON testing_user_response (user_ulid)');
        $this->addSql('CREATE INDEX IDX_1454CB32BBB901EE ON testing_user_response (testing_session_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE testing_user_response DROP CONSTRAINT FK_1454CB32BBB901EE');
        $this->addSql('DROP SEQUENCE testing_testing_session_id_seq CASCADE');
        $this->addSql('ALTER TABLE testing_testing_session DROP CONSTRAINT FK_485F2E0AB8098490');
        $this->addSql('DROP TABLE testing_testing_session');
        $this->addSql('ALTER TABLE testing_user_response DROP CONSTRAINT fk_1454cb32b8098490');
        $this->addSql('DROP INDEX IDX_1454CB32B8098490');
        $this->addSql('DROP INDEX IDX_1454CB32BBB901EE');
        $this->addSql('ALTER TABLE testing_user_response DROP testing_session_id');
        $this->addSql('CREATE SEQUENCE testing_user_response_id_seq');
        $this->addSql('SELECT setval(\'testing_user_response_id_seq\', (SELECT MAX(id) FROM testing_user_response))');
        $this->addSql('ALTER TABLE testing_user_response ALTER id SET DEFAULT nextval(\'testing_user_response_id_seq\')');
        $this->addSql('ALTER TABLE testing_user_response ADD CONSTRAINT fk_1454cb32b8098490 FOREIGN KEY (user_ulid) REFERENCES users_user (ulid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_1454cb32b8098490 ON testing_user_response (user_ulid)');
        $this->addSql('CREATE SEQUENCE testing_correct_answer_id_seq');
        $this->addSql('SELECT setval(\'testing_correct_answer_id_seq\', (SELECT MAX(id) FROM testing_correct_answer))');
        $this->addSql('ALTER TABLE testing_correct_answer ALTER id SET DEFAULT nextval(\'testing_correct_answer_id_seq\')');
    }
}
