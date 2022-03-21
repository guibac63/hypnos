<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220321200459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrator (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, INDEX IDX_C74404559D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etablissement (id INT AUTO_INCREMENT NOT NULL, admin_id_id INT NOT NULL, manager_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, address LONGTEXT NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, INDEX IDX_20FD592CDF6E65AD (admin_id_id), UNIQUE INDEX UNIQ_20FD592C569B5E6D (manager_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery (id INT AUTO_INCREMENT NOT NULL, suite_id_id INT NOT NULL, file VARCHAR(255) NOT NULL, INDEX IDX_472B783A59CDD37D (suite_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manager (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, admin_id_id INT NOT NULL, INDEX IDX_FA2425B99D86650F (user_id_id), INDEX IDX_FA2425B9DF6E65AD (admin_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, suite_id_id INT NOT NULL, client_id_id INT NOT NULL, beginning_date DATE NOT NULL, ending_date DATE NOT NULL, creation_date DATETIME NOT NULL, INDEX IDX_42C8495559CDD37D (suite_id_id), INDEX IDX_42C84955DC2902E0 (client_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suite (id INT AUTO_INCREMENT NOT NULL, etablissement_id_id INT NOT NULL, manager_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, price INT NOT NULL, main_image INT NOT NULL, link VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, INDEX IDX_153CE426FC5092A6 (etablissement_id_id), INDEX IDX_153CE426569B5E6D (manager_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404559D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE etablissement ADD CONSTRAINT FK_20FD592CDF6E65AD FOREIGN KEY (admin_id_id) REFERENCES administrator (id)');
        $this->addSql('ALTER TABLE etablissement ADD CONSTRAINT FK_20FD592C569B5E6D FOREIGN KEY (manager_id_id) REFERENCES manager (id)');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783A59CDD37D FOREIGN KEY (suite_id_id) REFERENCES suite (id)');
        $this->addSql('ALTER TABLE manager ADD CONSTRAINT FK_FA2425B99D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE manager ADD CONSTRAINT FK_FA2425B9DF6E65AD FOREIGN KEY (admin_id_id) REFERENCES administrator (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495559CDD37D FOREIGN KEY (suite_id_id) REFERENCES suite (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955DC2902E0 FOREIGN KEY (client_id_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE suite ADD CONSTRAINT FK_153CE426FC5092A6 FOREIGN KEY (etablissement_id_id) REFERENCES etablissement (id)');
        $this->addSql('ALTER TABLE suite ADD CONSTRAINT FK_153CE426569B5E6D FOREIGN KEY (manager_id_id) REFERENCES manager (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etablissement DROP FOREIGN KEY FK_20FD592CDF6E65AD');
        $this->addSql('ALTER TABLE manager DROP FOREIGN KEY FK_FA2425B9DF6E65AD');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955DC2902E0');
        $this->addSql('ALTER TABLE suite DROP FOREIGN KEY FK_153CE426FC5092A6');
        $this->addSql('ALTER TABLE etablissement DROP FOREIGN KEY FK_20FD592C569B5E6D');
        $this->addSql('ALTER TABLE suite DROP FOREIGN KEY FK_153CE426569B5E6D');
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783A59CDD37D');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495559CDD37D');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404559D86650F');
        $this->addSql('ALTER TABLE manager DROP FOREIGN KEY FK_FA2425B99D86650F');
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
