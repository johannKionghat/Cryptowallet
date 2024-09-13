<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240722165330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cryptocurrency (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, abreviation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, wallet_crypto_id INT DEFAULT NULL, user_to_id INT DEFAULT NULL, amount_crypto DOUBLE PRECISION NOT NULL, amount_euro DOUBLE PRECISION NOT NULL, type VARCHAR(255) NOT NULL, date_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_723705D1A76ED395 (user_id), INDEX IDX_723705D1BECB0AF2 (wallet_crypto_id), INDEX IDX_723705D1D2F7B13D (user_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, country_from VARCHAR(255) DEFAULT NULL, city_from VARCHAR(255) DEFAULT NULL, date_birth DATE DEFAULT NULL, country_birth VARCHAR(255) DEFAULT NULL, city_birth VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, telephone INT DEFAULT NULL, image_profil VARCHAR(255) DEFAULT NULL, zipcode INT DEFAULT NULL, language VARCHAR(255) DEFAULT NULL, date_at DATETIME DEFAULT NULL, currency VARCHAR(255) DEFAULT NULL, balance INT NOT NULL, thumbnail VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallet (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_7C68921F79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallet_crypto (id INT AUTO_INCREMENT NOT NULL, wallet_id INT DEFAULT NULL, crypto_id INT DEFAULT NULL, solde NUMERIC(10, 6) NOT NULL, activation TINYINT(1) NOT NULL, name_crypto VARCHAR(255) NOT NULL, INDEX IDX_D888B7C1712520F3 (wallet_id), INDEX IDX_D888B7C1E9571A63 (crypto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1BECB0AF2 FOREIGN KEY (wallet_crypto_id) REFERENCES wallet_crypto (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1D2F7B13D FOREIGN KEY (user_to_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE wallet_crypto ADD CONSTRAINT FK_D888B7C1712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
        $this->addSql('ALTER TABLE wallet_crypto ADD CONSTRAINT FK_D888B7C1E9571A63 FOREIGN KEY (crypto_id) REFERENCES cryptocurrency (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A76ED395');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1BECB0AF2');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1D2F7B13D');
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY FK_7C68921F79F37AE5');
        $this->addSql('ALTER TABLE wallet_crypto DROP FOREIGN KEY FK_D888B7C1712520F3');
        $this->addSql('ALTER TABLE wallet_crypto DROP FOREIGN KEY FK_D888B7C1E9571A63');
        $this->addSql('DROP TABLE cryptocurrency');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE wallet');
        $this->addSql('DROP TABLE wallet_crypto');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
