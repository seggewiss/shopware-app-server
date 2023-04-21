<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211116220236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add created_at and updated_at datetime fields';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE shop ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD sw_version VARCHAR(255) DEFAULT NULL, ADD app_version VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE shop DROP created_at, DROP updated_at, DROP sw_version, DROP app_version');
    }
}
