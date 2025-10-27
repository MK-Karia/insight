<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251027173528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creating ARTICLE_RATING';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE article_rating (
            article_id CHAR(36) NOT NULL,
            user_id CHAR(36) NOT NULL,
            `like` BOOLEAN NOT NULL,
            PRIMARY KEY(article_id, user_id),
            CONSTRAINT FK_ARTICLE_RATING_ARTICLE FOREIGN KEY(article_id) REFERENCES article(article_id) ON DELETE CASCADE,
            CONSTRAINT FK_ARTICLE_RATING_USER FOREIGN KEY(user_id) REFERENCES user(user_id) ON DELETE CASCADE
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE article_rating');
    }

}
