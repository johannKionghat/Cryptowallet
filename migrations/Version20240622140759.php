<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240622140759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE story_transaction DROP FOREIGN KEY FK_821F6D6E12A67609');
        $this->addSql('ALTER TABLE story_transaction DROP FOREIGN KEY FK_821F6D6E79F37AE5');
        $this->addSql('DROP TABLE story_transaction');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A908A82D');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D179F37AE5');
        $this->addSql('DROP INDEX UNIQ_723705D1A908A82D ON transaction');
        $this->addSql('DROP INDEX IDX_723705D179F37AE5 ON transaction');
        $this->addSql('ALTER TABLE transaction ADD user_id INT DEFAULT NULL, ADD wallet_crypto_id INT DEFAULT NULL, ADD amount_crypto DOUBLE PRECISION NOT NULL, ADD amount_euro DOUBLE PRECISION NOT NULL, ADD type VARCHAR(255) NOT NULL, DROP id_user_id, DROP id_cryptocurrency_id, DROP date_transaction_at, DROP type_transaction, DROP amount_transaction, DROP price_crypto');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1BECB0AF2 FOREIGN KEY (wallet_crypto_id) REFERENCES wallet_crypto (id)');
        $this->addSql('CREATE INDEX IDX_723705D1A76ED395 ON transaction (user_id)');
        $this->addSql('CREATE INDEX IDX_723705D1BECB0AF2 ON transaction (wallet_crypto_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE story_transaction (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, id_transaction_id INT DEFAULT NULL, type_action VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description_action VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date_action_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_821F6D6E12A67609 (id_transaction_id), INDEX IDX_821F6D6E79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE story_transaction ADD CONSTRAINT FK_821F6D6E12A67609 FOREIGN KEY (id_transaction_id) REFERENCES transaction (id)');
        $this->addSql('ALTER TABLE story_transaction ADD CONSTRAINT FK_821F6D6E79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A76ED395');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1BECB0AF2');
        $this->addSql('DROP INDEX IDX_723705D1A76ED395 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1BECB0AF2 ON transaction');
        $this->addSql('ALTER TABLE transaction ADD id_user_id INT DEFAULT NULL, ADD id_cryptocurrency_id INT DEFAULT NULL, ADD date_transaction_at DATETIME DEFAULT NULL, ADD type_transaction VARCHAR(255) DEFAULT NULL, ADD amount_transaction INT DEFAULT NULL, ADD price_crypto INT DEFAULT NULL, DROP user_id, DROP wallet_crypto_id, DROP amount_crypto, DROP amount_euro, DROP type');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A908A82D FOREIGN KEY (id_cryptocurrency_id) REFERENCES cryptocurrency (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D179F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_723705D1A908A82D ON transaction (id_cryptocurrency_id)');
        $this->addSql('CREATE INDEX IDX_723705D179F37AE5 ON transaction (id_user_id)');
    }
}
