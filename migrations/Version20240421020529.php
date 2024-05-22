<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240421020529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD username VARCHAR(255) NOT NULL, ADD firstname VARCHAR(255) DEFAULT NULL, ADD lastname VARCHAR(255) DEFAULT NULL, ADD country_from VARCHAR(255) DEFAULT NULL, ADD city_from VARCHAR(255) DEFAULT NULL, ADD date_birth DATE DEFAULT NULL, ADD country_birth VARCHAR(255) DEFAULT NULL, ADD city_birth VARCHAR(255) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD telephone INT DEFAULT NULL, ADD image_profil VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP username, DROP firstname, DROP lastname, DROP country_from, DROP city_from, DROP date_birth, DROP country_birth, DROP city_birth, DROP address, DROP telephone, DROP image_profil');
    }
}
