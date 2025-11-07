<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251027173439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creating ARTICLE';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE article (
            article_id CHAR(36) NOT NULL,
            title VARCHAR(255) NOT NULL,
            image VARCHAR(255) DEFAULT NULL,
            description VARCHAR(500) DEFAULT NULL,
            content JSON NOT NULL,
            author_id CHAR(36) DEFAULT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME DEFAULT NULL,
            PRIMARY KEY(article_id),
            CONSTRAINT FK_ARTICLE_AUTHOR FOREIGN KEY (author_id) REFERENCES user(user_id) ON DELETE SET NULL
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE article');
    }

}
