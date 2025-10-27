<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251027173626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creating COMMENT';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE comment (
            comment_id INT AUTO_INCREMENT NOT NULL,
            author_id CHAR(36) NOT NULL,
            article_id CHAR(36) NOT NULL,
            created_at DATETIME NOT NULL,
            is_edited BOOLEAN NOT NULL,
            content TEXT NOT NULL,
            previous_comment_id INT DEFAULT NULL,
            PRIMARY KEY(comment_id),
            CONSTRAINT FK_COMMENT_AUTHOR FOREIGN KEY(author_id) REFERENCES user(user_id) ON DELETE RESTRICT,
            CONSTRAINT FK_COMMENT_ARTICLE FOREIGN KEY(article_id) REFERENCES article(article_id) ON DELETE CASCADE,
            CONSTRAINT FK_COMMENT_PREVIOUS FOREIGN KEY(previous_comment_id) REFERENCES comment(comment_id) ON DELETE SET NULL
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE comment');
    }

}
