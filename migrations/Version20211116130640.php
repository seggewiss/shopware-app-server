<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211116130640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds base tables to the database';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE shop (id VARCHAR(255) NOT NULL, shop_url VARCHAR(255) NOT NULL, shop_secret VARCHAR(255) NOT NULL, api_key VARCHAR(255) DEFAULT NULL, secret_key VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE shop');
    }
}
