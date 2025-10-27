<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251027173249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creating USER';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user (
            user_id CHAR(36) NOT NULL,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            birthdate DATE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role_id INT NOT NULL,
            avatar VARCHAR(255) DEFAULT NULL,
            PRIMARY KEY(user_id),
            CONSTRAINT FK_USER_ROLE FOREIGN KEY (role_id) REFERENCES role(role_id) ON DELETE RESTRICT
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user');
    }

}
