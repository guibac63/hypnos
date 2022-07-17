<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220321204404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrator (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, INDEX IDX_58DF0651A76ED395 (user_id), 
        PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, INDEX IDX_C7440455A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etablissement (id INT AUTO_INCREMENT NOT NULL, admin_id INT NOT NULL, manager_id INT NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, address LONGTEXT NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, INDEX IDX_20FD592C642B8210 (admin_id), UNIQUE INDEX UNIQ_20FD592C783E3463 (manager_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery (id INT AUTO_INCREMENT NOT NULL, suite_id INT NOT NULL, image VARCHAR(255) NOT NULL,creation_date DATETIME NOT NULL, INDEX IDX_472B783A4FFCB518 (suite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manager (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, admin_id INT NOT NULL, INDEX IDX_FA2425B9A76ED395 (user_id), INDEX IDX_FA2425B9642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, suite_id INT NOT NULL, client_id INT NOT NULL, beginning_date DATE NOT NULL, ending_date DATE NOT NULL, creation_date DATETIME NOT NULL, INDEX IDX_42C849554FFCB518 (suite_id), INDEX IDX_42C8495519EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suite (id INT AUTO_INCREMENT NOT NULL, etablissement_id INT NOT NULL, manager_id INT NOT NULL, title VARCHAR(255) NOT NULL, price INT NOT NULL, main_image INT NOT NULL, link VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, INDEX IDX_153CE426FF631228 (etablissement_id), INDEX IDX_153CE426783E3463 (manager_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE etablissement ADD CONSTRAINT FK_20FD592C642B8210 FOREIGN KEY (admin_id) REFERENCES administrator (id)');
        $this->addSql('ALTER TABLE etablissement ADD CONSTRAINT FK_20FD592C783E3463 FOREIGN KEY (manager_id) REFERENCES manager (id)');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783A4FFCB518 FOREIGN KEY (suite_id) REFERENCES suite (id)');
        $this->addSql('ALTER TABLE manager ADD CONSTRAINT FK_FA2425B9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE manager ADD CONSTRAINT FK_FA2425B9642B8210 FOREIGN KEY (admin_id) REFERENCES administrator (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849554FFCB518 FOREIGN KEY (suite_id) REFERENCES suite (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE suite ADD CONSTRAINT FK_153CE426FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
        $this->addSql('ALTER TABLE suite ADD CONSTRAINT FK_153CE426783E3463 FOREIGN KEY (manager_id) REFERENCES manager (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etablissement DROP FOREIGN KEY FK_20FD592C642B8210');
        $this->addSql('ALTER TABLE manager DROP FOREIGN KEY FK_FA2425B9642B8210');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495519EB6921');
        $this->addSql('ALTER TABLE suite DROP FOREIGN KEY FK_153CE426FF631228');
        $this->addSql('ALTER TABLE etablissement DROP FOREIGN KEY FK_20FD592C783E3463');
        $this->addSql('ALTER TABLE suite DROP FOREIGN KEY FK_153CE426783E3463');
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783A4FFCB518');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849554FFCB518');
        $this->addSql('ALTER TABLE administrator DROP FOREIGN KEY FK_58DF0651A76ED395');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455A76ED395');
        $this->addSql('ALTER TABLE manager DROP FOREIGN KEY FK_FA2425B9A76ED395');
        $this->addSql('DROP TABLE administrator');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE etablissement');
        $this->addSql('DROP TABLE gallery');
        $this->addSql('DROP TABLE manager');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE suite');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
