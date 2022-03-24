<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220324204604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrator DROP FOREIGN KEY FK_58DF0651A76ED395');
        $this->addSql('DROP INDEX IDX_58DF0651A76ED395 ON administrator');
        $this->addSql('ALTER TABLE administrator CHANGE user_id main_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF065153257A7C FOREIGN KEY (main_user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_58DF065153257A7C ON administrator (main_user_id)');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455A76ED395');
        $this->addSql('DROP INDEX IDX_C7440455A76ED395 ON client');
        $this->addSql('ALTER TABLE client CHANGE user_id main_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045553257A7C FOREIGN KEY (main_user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C744045553257A7C ON client (main_user_id)');
        $this->addSql('ALTER TABLE manager DROP FOREIGN KEY FK_FA2425B9A76ED395');
        $this->addSql('DROP INDEX IDX_FA2425B9A76ED395 ON manager');
        $this->addSql('ALTER TABLE manager CHANGE user_id main_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE manager ADD CONSTRAINT FK_FA2425B953257A7C FOREIGN KEY (main_user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FA2425B953257A7C ON manager (main_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrator DROP FOREIGN KEY FK_58DF065153257A7C');
        $this->addSql('DROP INDEX UNIQ_58DF065153257A7C ON administrator');
        $this->addSql('ALTER TABLE administrator CHANGE main_user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_58DF0651A76ED395 ON administrator (user_id)');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045553257A7C');
        $this->addSql('DROP INDEX UNIQ_C744045553257A7C ON client');
        $this->addSql('ALTER TABLE client CHANGE main_user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C7440455A76ED395 ON client (user_id)');
        $this->addSql('ALTER TABLE manager DROP FOREIGN KEY FK_FA2425B953257A7C');
        $this->addSql('DROP INDEX UNIQ_FA2425B953257A7C ON manager');
        $this->addSql('ALTER TABLE manager CHANGE main_user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE manager ADD CONSTRAINT FK_FA2425B9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FA2425B9A76ED395 ON manager (user_id)');
    }
}
