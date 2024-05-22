<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240512210428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cryptocurrency (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, current_price INT NOT NULL, image VARCHAR(255) NOT NULL, abreviation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE story_transaction (id INT AUTO_INCREMENT NOT NULL, type_action VARCHAR(255) DEFAULT NULL, description_action VARCHAR(255) DEFAULT NULL, date_action_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE crypto');
        $this->addSql('DROP TABLE rating');
        $this->addSql('ALTER TABLE transaction ADD type_transaction VARCHAR(255) DEFAULT NULL, ADD amount_transaction INT DEFAULT NULL, ADD price_crypto INT DEFAULT NULL, DROP amount, DROP type, DROP payment_methode, DROP fee, DROP state, CHANGE date_transaction date_transaction_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD balance INT NOT NULL');
        $this->addSql('ALTER TABLE wallet ADD quantity_crypto INT DEFAULT NULL, DROP balance, DROP secret_sentence');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, name_account VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE crypto (id INT AUTO_INCREMENT NOT NULL, name_crypto VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, short_name_crypto VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, logo_crypto VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, price_crypto NUMERIC(10, 2) NOT NULL, rating_crypto NUMERIC(10, 2) NOT NULL, date_rating DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE cryptocurrency');
        $this->addSql('DROP TABLE story_transaction');
        $this->addSql('ALTER TABLE transaction ADD amount NUMERIC(10, 2) NOT NULL, ADD type NUMERIC(10, 0) NOT NULL, ADD payment_methode VARCHAR(255) NOT NULL, ADD fee NUMERIC(10, 2) NOT NULL, ADD state TINYINT(1) NOT NULL, DROP type_transaction, DROP amount_transaction, DROP price_crypto, CHANGE date_transaction_at date_transaction DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` DROP balance');
        $this->addSql('ALTER TABLE wallet ADD balance NUMERIC(10, 2) NOT NULL, ADD secret_sentence LONGTEXT NOT NULL, DROP quantity_crypto');
    }
}
