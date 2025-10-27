<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251027170157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creating ROLE';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE role (
            role_id INT AUTO_INCREMENT NOT NULL,
            role_name VARCHAR(50) NOT NULL,
            PRIMARY KEY(role_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE role');
    }

}
