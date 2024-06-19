<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240617064738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallet_crypto ADD wallet_id INT DEFAULT NULL, ADD crypto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE wallet_crypto ADD CONSTRAINT FK_D888B7C1712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
        $this->addSql('ALTER TABLE wallet_crypto ADD CONSTRAINT FK_D888B7C1E9571A63 FOREIGN KEY (crypto_id) REFERENCES cryptocurrency (id)');
        $this->addSql('CREATE INDEX IDX_D888B7C1712520F3 ON wallet_crypto (wallet_id)');
        $this->addSql('CREATE INDEX IDX_D888B7C1E9571A63 ON wallet_crypto (crypto_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallet_crypto DROP FOREIGN KEY FK_D888B7C1712520F3');
        $this->addSql('ALTER TABLE wallet_crypto DROP FOREIGN KEY FK_D888B7C1E9571A63');
        $this->addSql('DROP INDEX IDX_D888B7C1712520F3 ON wallet_crypto');
        $this->addSql('DROP INDEX IDX_D888B7C1E9571A63 ON wallet_crypto');
        $this->addSql('ALTER TABLE wallet_crypto DROP wallet_id, DROP crypto_id');
    }
}
