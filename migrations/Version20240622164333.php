<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240622164333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction ADD user_to_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1D2F7B13D FOREIGN KEY (user_to_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_723705D1D2F7B13D ON transaction (user_to_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1D2F7B13D');
        $this->addSql('DROP INDEX IDX_723705D1D2F7B13D ON transaction');
        $this->addSql('ALTER TABLE transaction DROP user_to_id');
    }
}
