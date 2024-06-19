<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240617063804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cryptocurrency DROP FOREIGN KEY FK_CC62CFADF1109CD4');
        $this->addSql('DROP INDEX IDX_CC62CFADF1109CD4 ON cryptocurrency');
        $this->addSql('ALTER TABLE cryptocurrency DROP id_wallet_id');
        $this->addSql('ALTER TABLE wallet_crypto DROP FOREIGN KEY FK_D888B7C169F28E2C');
        $this->addSql('ALTER TABLE wallet_crypto DROP FOREIGN KEY FK_D888B7C1F43F82D');
        $this->addSql('ALTER TABLE wallet_crypto DROP FOREIGN KEY FK_D888B7C1E9571A63');
        $this->addSql('DROP INDEX UNIQ_D888B7C169F28E2C ON wallet_crypto');
        $this->addSql('DROP INDEX IDX_D888B7C1E9571A63 ON wallet_crypto');
        $this->addSql('DROP INDEX UNIQ_D888B7C1F43F82D ON wallet_crypto');
        $this->addSql('ALTER TABLE wallet_crypto DROP wallet_id_id, DROP crypto_id_id, DROP crypto_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cryptocurrency ADD id_wallet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cryptocurrency ADD CONSTRAINT FK_CC62CFADF1109CD4 FOREIGN KEY (id_wallet_id) REFERENCES wallet (id)');
        $this->addSql('CREATE INDEX IDX_CC62CFADF1109CD4 ON cryptocurrency (id_wallet_id)');
        $this->addSql('ALTER TABLE wallet_crypto ADD wallet_id_id INT DEFAULT NULL, ADD crypto_id_id INT DEFAULT NULL, ADD crypto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE wallet_crypto ADD CONSTRAINT FK_D888B7C169F28E2C FOREIGN KEY (crypto_id_id) REFERENCES cryptocurrency (id)');
        $this->addSql('ALTER TABLE wallet_crypto ADD CONSTRAINT FK_D888B7C1F43F82D FOREIGN KEY (wallet_id_id) REFERENCES wallet (id)');
        $this->addSql('ALTER TABLE wallet_crypto ADD CONSTRAINT FK_D888B7C1E9571A63 FOREIGN KEY (crypto_id) REFERENCES cryptocurrency (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D888B7C169F28E2C ON wallet_crypto (crypto_id_id)');
        $this->addSql('CREATE INDEX IDX_D888B7C1E9571A63 ON wallet_crypto (crypto_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D888B7C1F43F82D ON wallet_crypto (wallet_id_id)');
    }
}
