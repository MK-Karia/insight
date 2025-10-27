<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251027173711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creating CATEGORY';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE category (
            category_id CHAR(36) NOT NULL,
            category_name VARCHAR(100) NOT NULL,
            PRIMARY KEY(category_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE category');
    }

}
